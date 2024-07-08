<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use App\Constants\Status;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppointmentController extends Controller
{
    public function index()
    {
        $pageTitle    = 'Manage Appointments';
        $appointments = Appointment::searchable(['email', 'mobile', 'unique_id'])
            ->filter(['status'])
            ->dateFilter('appointment_date')
            ->Where('user_id', auth()->user()->id)
            ->orWhere('user_id', auth()->user()->parent_id)
            ->orderBy('status', 'asc')
            ->orderBy('appointment_date', 'asc')
            ->paginate(getPaginate(10));

        return view('Template::user.appointment.index', compact('pageTitle', 'appointments'));
    }

    public function store(Request $request, $id = 0)
    {

        $staff = auth()->user();

        if ($staff->is_staff) {
            $user = User::active()->findOrFail($staff->parent_id);
        } else {
            $user = auth()->user();
        }

        if (!$user->pricing_id) {
            $notify[] = ['error', 'Please purchase a plan'];
            return to_route('pricing')->withNotify($notify);
        }

        if ($user->expire_on <= now()) {
            $notify[] = ['error', 'Your purchase plan has been expired'];
            return back()->withNotify($notify);
        }

        $dailyLimit   = $user->daily_appointment_limit;
        $monthlyLimit = $user->monthly_appointment_limit;

        $today       = Carbon::today();
        $currentTime = Carbon::now()->format('H:i:s');
        $thisMonth   = Carbon::now()->startOfMonth();

        $appointmentToday     = Appointment::where('user_id', $user->id)->whereDate('created_at', $today)->count();
        $appointmentThisMonth = Appointment::where('user_id', $user->id)->whereDate('created_at', '>=', $thisMonth)->count();

        if ($appointmentToday >= $dailyLimit) {
            $notify[] = ['error', 'Your daily appointment limit reached'];
        }

        if ($appointmentThisMonth >= $monthlyLimit) {
            $notify[] = ['error', 'Your monthly appointment limit reached'];
        }

        if (!empty($notify)) {
            return back()->withNotify($notify);
        }

        $request->validate([
            'name'             => 'required|string|max:40',
            'age'              => 'nullable',
            'gender'           => 'required',
            'email'            => 'nullable',
            'mobile'           => 'required',
            'appointment_date' => 'required|date|after_or_equal:' . $today->format('Y-m-d'),
            'appointment_time' => [
                $request->appointment_date === $today->format('Y-m-d') ? 'required' : '',
                'nullable',
                'after_or_equal:' . ($request->appointment_date === $today->format('Y-m-d') ? $currentTime : '00:00:00'),
            ],
        ]);

        if ($id) {
            $appointment = Appointment::where('status', Status::UPCOMING_APPOINTMENT)->where('user_id', $user->id)->findOrFail($id);
            $notify[]    = ['success', 'Appointment updated successfully'];
            if ($appointment->appointment_date != $request->appointment_date || $appointment->appointment_time != $request->appointment_time) {
                $this->sendAppointmentNotification($appointment);
            }
        } else {

            $appointment            = new Appointment();
            $appointment->unique_id = $this->uniqid($user);
            $appointment->user_id   = $user->id;

            $notify[] = ['success', 'Appointment added successfully'];
        }

        $appointment->name             = $request->name;
        $appointment->age              = $request->age;
        $appointment->gender           = $request->gender;
        $appointment->email            = $request->email;
        $appointment->mobile           = $request->mobile;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->status           = Status::UPCOMING_APPOINTMENT;
        $appointment->save();

        if (!$id) {
            $this->sendAppointmentNotification($appointment);
        }

        return back()->withNotify($notify);
    }

    private function sendAppointmentNotification($appointment)
    {
        $statusLabels = [
            1 => 'Upcoming',
            2 => 'Completed',
            3 => 'Cancelled'
        ];

        $user = [
            'email'    => $appointment->email,
            'mobile'   => $appointment->mobile,
            'fullname' => $appointment->name,
            'username' => $appointment->name,
            '' => true,
        ];

        notify($user, 'APPOINTMENT_CREATE', [
            'appointment_sub'  => $appointment->name,
            'appointment_time' => $appointment->appointment_time,
            'appointment_date' => $appointment->appointment_date,
            'appointment_msg'  => $statusLabels[$appointment->status]
        ]);
    }

    public function status(Request $request, $id)
    {

        $staff = auth()->user();
        if ($staff->is_staff) {
            $user = User::findOrFail($staff->parent_id);
        } else {
            $user = auth()->user();
        }
        if ($user->expire_on <= now()) {
            $notify[] = ['error', 'Your purchase plan has been expired'];
            return back()->withNotify($notify);
        }

        $appointment         = Appointment::where('user_id', $user->id)->where('status', Status::UPCOMING_APPOINTMENT)->findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();

        $user = [
            'email' => $appointment->email,
            'mobile' => $appointment->mobile,
            'fullname' => $appointment->name,
            'username' => $appointment->name,
        ];

        $statusLabels = [
            1 => 'Upcoming',
            3 => 'Cancelled'
        ];

        $contactUrl = route('contact');

        if ($appointment->status == Status::COMPLETED_APPOINTMENT) {
            $notify[] = ['success', 'Appointment status changed successfully'];
            return back()->withNotify($notify);
        } else {
            notify($user, 'APPOINTMENT_CANCELLED', [
                'appointment_sub' => $appointment->name,
                'appointment_time' => $appointment->appointment_time,
                'appointment_date' => $appointment->appointment_date,
                'appointment_msg' => $statusLabels[$appointment->status],
                'contact_url' => $contactUrl

            ]);
            $notify[] = ['success', 'Appointment status changed successfully'];
            return back()->withNotify($notify);
        }
    }
    private function uniqid($user)
    {
        $uniqueId           = str_replace("-", "", now()->toDateString());
        $appointmentCount  = Appointment::where('user_id', $user->id)->whereDate('created_at', '>=', now())->count() + 1;

        return $user->id . '-' . $uniqueId . '-' . ($appointmentCount < 10 ? "0" . $appointmentCount : $appointmentCount);
    }
}
