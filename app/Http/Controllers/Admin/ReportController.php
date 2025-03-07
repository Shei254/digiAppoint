<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\NotificationLog;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction(Request $request)
    {
        $pageTitle = 'Payment Logs';


        $payments = Deposit::searchable(['user:username'])->filter(['pricing_type'])->dateFilter()->orderBy('id','desc')->with('user','pricing')->paginate(getPaginate());

        return view('admin.reports.transactions', compact('pageTitle', 'payments'));
    }

    public function loginHistory(Request $request)
    {
        $pageTitle = 'User Login History';
        $loginLogs = UserLogin::orderBy('id','desc')->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('user_ip',$ip)->orderBy('id','desc')->with('user')->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'loginLogs','ip'));
    }

    public function notificationHistory(Request $request){
        $pageTitle = 'Notification History';
        $logs = NotificationLog::orderBy('id','desc')->searchable(['user:username'])->with('user')->paginate(getPaginate());
        return view('admin.reports.notification_history', compact('pageTitle','logs'));
    }

    public function emailDetails($id){
        $pageTitle = 'Email Details';
        $email = NotificationLog::findOrFail($id);
        return view('admin.reports.email_details', compact('pageTitle','email'));
    }
}
