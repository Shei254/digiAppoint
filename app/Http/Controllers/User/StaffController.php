<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Constants\Status;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    public function getStaff()
    {
        $pageTitle = 'Manage Staff';
        $staffs = User::where('parent_id', auth()->user()->id)->paginate(getPaginate());
        return view('Template::user.staff.list', compact('pageTitle', 'staffs'));
    }

    public function addStaff()
    {

        $user=auth()->user();

        if(!$user->pricing_id){
            $notify[] = ['error', 'Please purchase a plan'];
            return redirect(route('pricing'))->withNotify($notify);
        }
        if ($user->expire_on <= now()) {
            $notify[] = ['error', 'Your purchase plan has been expired'];
            return back()->withNotify($notify);
        }
        if ($user->staff_limit <= 0) {
            $notify[] = ['error', 'You\'ve no limit to add new staff'];
            return back()->withNotify($notify);
        }

        if ($user->parent_id) {
            $notify[] = ['error', 'You\'ve no access to add new staff'];
            return back()->withNotify($notify);
        }

        $pageTitle  = 'Create Staff Profile';
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));

        return view('Template::user.staff.add', compact('pageTitle', 'mobileCode', 'countries'));
    }


    public function staffRegister(Request $request)
    {
        if (auth()->user()->expire_on <= now()) {
            $notify[] = ['error', 'Your purchase plan has been expired'];
            return back()->withNotify($notify);
        }

        if (auth()->user()->staff_limit <= 0) {
            $notify[] = ['error', 'You\'ve no limit to add new staff'];
            return back()->withNotify($notify);
        }

        $passwordValidation = Password::min(6);
        $countryData        = (array) json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes       = implode(',', array_keys($countryData));
        $mobileCodes        = implode(',', array_column($countryData, 'dial_code'));
        $countries          = implode(',', array_column($countryData, 'country'));

        $request->validate([
            'email'        => 'required|string|email|unique:users',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'mobile'       => 'required|regex:/^([0-9]*)$/',
            'password'     => ['required', $passwordValidation],
            'username'     => 'required|unique:users|min:6',
            'dial_code'  => 'required|in:' . $mobileCodes,
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
        ]);

        $user               = new User();
        $user->email        = strtolower($request->email);
        $user->password     = Hash::make($request->password);
        $user->username     = $request['username'];
        $user->country_code = $request['country_code'];
        $user->mobile       = $request['dial_code'] . $request['mobile'];
     
        $user->firstname    = $request->firstname;
        $user->lastname     = $request->lastname;
        $user->address      = $request->address;
        $user->state        = $request->state;
        $user->zip          = $request->zip;
        $user->country_name = isset($request['country']) ? $request['country'] : null;
        $user->city         = $request->city;
        
        $user->ev               = Status::YES;
        $user->sv               = Status::YES;
        $user->ts               = Status::NO;
        $user->tv               = Status::YES;
        $user->is_staff         = Status::YES;
        $user->profile_complete = Status::YES;
        $user->parent_id        = auth()->user()->id;

        $user->save();

        $pricingUser               = auth()->user();
        $pricingUser->staff_limit -= 1;
        $pricingUser->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New Staff registered';
        $adminNotification->click_url = urlPath('admin.users.detail', $user->id);
        $adminNotification->save();

        $loginUrl = route('user.login');

        notify($user, 'STAFF_NOTIFICATION', [
            'email'          => $user->email,
            'mobile'         => $user->mobile,
            'fullname'       => $user->name,
            'username'       => $user->username,
            'staff_name'     => $request->username,
            'staff_username' => $request->username,
            'staff_email'    => $request->email,
            'staff_password' => $request->password,
            'login_url'      => $loginUrl,
        ]);

        $notify[] = ['success', 'New staff added successfully'];
        return back()->withNotify($notify);
    }
    public function checkStaff(Request $request)
    {
        $exist['data'] = false;
        $exist['type'] = null;

        if ($request->email) {
            $exist['data'] = User::where('email', $request->email)->exists();
            $exist['type'] = 'email';
        }
        if ($request->mobile) {
            $exist['data'] = User::where('mobile', $request->mobile)->exists();
            $exist['type'] = 'mobile';
        }
        if ($request->username) {
            $exist['data'] = User::where('username', $request->username)->exists();
            $exist['type'] = 'username';
        }
        return response($exist);
    }

    public function staffProfile($id)
    {
        $pageTitle = "Update Staff Profile";
        $user      = User::where('parent_id', auth()->user()->id)->findOrFail($id);
        return view('Template::user.staff.edit', compact('pageTitle', 'user'));
    }

    public function updateStaff(Request $request)
    {
        if (auth()->user()->expire_on <= now()) {
            $notify[] = ['error', 'Your purchase plan has been expired'];
            return back()->withNotify($notify);
        }

        $request->validate([
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required'  => 'Last name field is required'
        ]);

        $user = User::where('parent_id', auth()->user()->id)->findOrFail($request->id);

        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;

        $user->address      = $request->address;
        $user->state        = $request->state;
        $user->zip          = $request->zip;
        $user->country_name = @$user->country_name;
        $user->city         = $request->city;

        $user->save();

        $notify[] = ['success', 'Staff profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function status(Request $request, $id)
    {
        if (auth()->user()->expire_on <= now()) {
            $notify[] = ['error', 'Your purchase plan has been expired'];
            return back()->withNotify($notify);
        }

        $user = User::where('parent_id',auth()->user()->id)->findOrFail($id);

        if ($user->status == Status::USER_ACTIVE) {
            $request->validate([
                'reason' => 'required|string|max:255'
            ]);
            $user->status     = Status::USER_BAN;
            $user->ban_reason = $request->reason;
            $notify[]         = ['success', 'Staff banned successfully'];
        } else {
            $user->status     = Status::USER_ACTIVE;
            $user->ban_reason = null;
            $notify[]         = ['success', 'Staff unbanned successfully'];
        }

        $user->save();
        return back()->withNotify($notify);
    }

}
