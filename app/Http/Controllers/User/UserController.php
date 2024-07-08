<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\DeviceToken;
use App\Models\Pricing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function home()
    {

        $staff = auth()->user();

        if ($staff->is_staff) {
            $user = User::findOrFail($staff->parent_id);
        } else {
            $user = auth()->user();
        }

        $pageTitle      = 'Dashboard';
        $completed      = Appointment::where('user_id', $user->id)->where('status', Status::COMPLETED_APPOINTMENT)->count();
        $upcoming       = Appointment::where('user_id', $user->id)->where('status', Status::UPCOMING_APPOINTMENT)->count();
        $cancelled       = Appointment::where('user_id', $user->id)->where('status', Status::CANCELLED_APPOINTMENT)->count();
        $total          = Appointment::where('user_id', $user->id)->count();
        $staffRemaining = $user->staff_limit;
        $today          = Carbon::today();
        $thisMonth      = Carbon::now()->startOfMonth();

        $todayAppointments = Appointment::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->count();

        $thisMonthAppointments = Appointment::where('user_id', $user->id)
            ->whereDate('created_at', '>=', $thisMonth)
            ->count();

        $todayRemaining = max($user->daily_appointment_limit - $todayAppointments, 0);
        $thisMonthRemaining = max($user->monthly_appointment_limit - $thisMonthAppointments, 0);

        $appointments = Appointment::where('user_id', $user->id)
            ->where('status', Status::UPCOMING_APPOINTMENT)
            ->dateFilter('appointment_date')
            ->orderBy('appointment_date', 'desc')
            ->limit(10)
            ->get();

        return view('Template::user.dashboard', compact('pageTitle', 'completed', 'upcoming', 'cancelled', 'total', 'appointments', 'staffRemaining', 'todayRemaining', 'thisMonthRemaining'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::user.deposit_history', compact('pageTitle', 'deposits'));
    }


    public function userData()
    {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $pageTitle  = 'User Data';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.user_data', compact('pageTitle', 'user', 'countries', 'mobileCode'));
    }

    public function userDataSubmit(Request $request)
    {

        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $countryData  = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'username'     => 'required|unique:users|min:6',
            'mobile' => ['required','regex:/^([0-9]*)$/',Rule::unique('users')->where('dial_code',$request->mobile_code)],
        ]);

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $user->country_code = $request->country_code;
        $user->mobile       = $request->mobile;
        $user->username     = $request->username;


        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;
        $user->country_name = @$request->country;
        $user->dial_code = $request->mobile_code;

        $user->profile_complete = Status::YES;
        $user->save();

        return to_route('user.home');
    }


    public function addDeviceToken(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()->all()];
        }

        $deviceToken = DeviceToken::where('token', $request->token)->first();

        if ($deviceToken) {
            return ['success' => true, 'message' => 'Already exists'];
        }

        $deviceToken          = new DeviceToken();
        $deviceToken->user_id = auth()->user()->id;
        $deviceToken->token   = $request->token;
        $deviceToken->is_app  = Status::NO;
        $deviceToken->save();

        return ['success' => true, 'message' => 'Token saved successfully'];
    }

    public function downloadAttachment($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $title = slug(gs('site_name')) . '- attachments.' . $extension;
        try {
            $mimetype = mime_content_type($filePath);
        } catch (\Exception $e) {
            $notify[] = ['error', 'File does not exists'];
            return back()->withNotify($notify);
        }
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }


    public function pricing()
    {
        $pageTitle = 'Purchase Plan';
        $pricing   = Pricing::active()->orderBy('monthly_price', 'asc')->get();
        return view('Template::user.pricing', compact('pageTitle', 'pricing'));
    }
}
