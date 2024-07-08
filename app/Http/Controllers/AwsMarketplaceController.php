<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\Intended;
use App\Models\AdminNotification;
use App\Models\Pricing;
use App\Models\User;
use App\Models\UserLogin;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Runner\Exception;
use Shei\AwsMarketplaceTools\Models\AwsCustomer;
use Shei\AwsMarketplaceTools\Models\AwsSubscription;

class AwsMarketplaceController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function show () {
        $pageTitle = "Register";
        Intended::identifyRoute();
        return view('Template::aws.register', compact('pageTitle'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function register (Request $request) {
        try {
            $agree = 'nullable';
            if (gs('agree')) {
                $agree = 'required';
            }

            $request->validate([
                'firstname' => 'required',
                'lastname'  => 'required',
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                "customer_id" => "required|string|max:255",
                'captcha'   => 'sometimes|required',
                'agree'     => $agree
            ],[
                'firstname.required'=>'The first name field is required',
                'lastname.required'=>'The last name field is required'
            ]);

            $awsUser = AwsCustomer::where("customer_id", $request->customer_id)->first();
            if (!$awsUser) {
                throw new \Exception("Could not find your associated aws account. Please set up your account through aws or through the app");
            }

            $awsSubscription = AwsSubscription::where("aws_customer_id", $awsUser->id)->latest()->first();
            if (!$awsSubscription) {
                throw new \Exception("Could not find an active subscription for your account");
            }

            //Fetch Plan
            $pricing = Pricing::where("name", $awsSubscription->dimension)->first();
            if (!$pricing) {
                throw new \Exception("Something went wrong. PLease contact support");
            }

            //Create new user & Assign PLan
            $request->session()->regenerateToken();

            if (!verifyCaptcha()) {
                $notify[] = ['error', 'Invalid captcha provided'];
                return back()->withNotify($notify);
            }

            event(new Registered($user = $this->create($request->all())));

            $this->guard()->login($user);

            $user->pricing_id                = $pricing->id;
            $user->staff_limit               = $pricing->staff_limit;
            $user->daily_appointment_limit   = $pricing->daily_appointment_limit;
            $user->monthly_appointment_limit = $pricing->monthly_appointment_limit;

            $expirationDate = $user->expire_on && !Carbon::parse($user->expired_on)->isPast() ? Carbon::parse($user->expire_on) : Carbon::now();
            $expirationDate->addMonth();

//            if ($deposit->pricing_type == 'monthly') {
//                $expirationDate->addMonth();
//            } else {
//                $expirationDate->addYear();
//            }

            $user->expire_on = $expirationDate->toDateTimeString();
            $user->save();

            $awsUser->user_id = $user->id;
            $awsUser->save();

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());
        } catch (\Exception $e) {
            dd($e);
            return redirect("/register")->with("error", $e->getMessage());
        }
    }

    protected function create(array $data)
    {
        $referBy = session()->get('reference');
        if ($referBy) {
            $referUser = User::where('username', $referBy)->first();
        } else {
            $referUser = null;
        }

        //User Create
        $user            = new User();
        $user->email     = strtolower($data['email']);
        $user->firstname = $data['firstname'];
        $user->lastname  = $data['lastname'];
        $user->password  = Hash::make($data['password']);
        $user->ev = gs('ev') ? Status::NO : Status::YES;
        $user->sv = gs('sv') ? Status::NO : Status::YES;
        $user->ts = Status::DISABLE;
        $user->tv = Status::ENABLE;
        $user->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New member registered';
        $adminNotification->click_url = urlPath('admin.users.detail', $user->id);
        $adminNotification->save();


        //Login Log Create
        $ip        = getRealIP();
        $exist     = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();

        if ($exist) {
            $userLogin->longitude    = $exist->longitude;
            $userLogin->latitude     = $exist->latitude;
            $userLogin->city         = $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country      = $exist->country;
        } else {
            $info                    = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude    = @implode(',', $info['long']);
            $userLogin->latitude     = @implode(',', $info['lat']);
            $userLogin->city         = @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country      = @implode(',', $info['country']);
        }

        $userAgent          = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os      = @$userAgent['os_platform'];
        $userLogin->save();


        return $user;
    }

    public function registered()
    {
        return to_route('user.home');
    }
}
