<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\CurlRequest;
use App\Models\Appointment;
use App\Models\CronJob;
use App\Models\CronJobLog;
use Carbon\Carbon;

class CronController extends Controller
{
    public function cron()
    {
        $general            = gs();
        $general->last_cron = now();
        $general->save();

        $crons = CronJob::with('schedule');

        if (request()->alias) {
            $crons->where('alias', request()->alias);
        } else {
            $crons->where('next_run', '<', now())->where('is_running', Status::YES);
        }
        $crons = $crons->get();
        foreach ($crons as $cron) {
            $cronLog              = new CronJobLog();
            $cronLog->cron_job_id = $cron->id;
            $cronLog->start_at    = now();
            if ($cron->is_default) {
                $controller = new $cron->action[0];
                try {
                    $method = $cron->action[1];
                    $controller->$method();
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            } else {
                try {
                    CurlRequest::curlContent($cron->url);
                } catch (\Exception $e) {
                    $cronLog->error = $e->getMessage();
                }
            }
            $cron->last_run = now();
            $cron->next_run = now()->addSeconds(@$cron->schedule->interval);
            $cron->save();

            $cronLog->end_at = $cron->last_run;

            $startTime         = Carbon::parse($cronLog->start_at);
            $endTime           = Carbon::parse($cronLog->end_at);
            $diffInSeconds     = $startTime->diffInSeconds($endTime);
            $cronLog->duration = $diffInSeconds;
            $cronLog->save();
        }
        if (request()->target == 'all') {
            $notify[] = ['success', 'Cron executed successfully'];
            return back()->withNotify($notify);
        }
        if (request()->alias) {
            $notify[] = ['success', keyToTitle(request()->alias) . ' executed successfully'];
            return back()->withNotify($notify);
        }
    }

    public function appointmentNotice()
    {

        $appointments = Appointment::where('status', Status::UPCOMING_APPOINTMENT)->where('is_notified', false)->where('appointment_date', '<=', now()->addDay())->get();

        $statusLabels = [
            1 => 'Upcoming',
            2 => 'Completed',
            3 => 'Cancelled'
        ];

        foreach ($appointments as $appointment) {

            $appointment = Appointment::findOrFail($appointment->id);
            $appointment->is_notified = true;
            $appointment->save();
            $user = [
                'email' => $appointment->email,
                'mobile' => $appointment->mobile,
                'fullname' => $appointment->name,
                'username' => $appointment->name,
            ];

            notify($user, 'APPOINTMENT_NOTIFICATION', [
                'appointment_sub' => $appointment->name,
                'appointment_msg' => $statusLabels[$appointment->status],
                'appointment_time' => $appointment->appointment_time,
                'appointment_date' => $appointment->appointment_date,
            ]);
        }
        $notify[] = ['success', ' Appointment notification sent successfully'];
        return back()->withNotify($notify);
    }



}
