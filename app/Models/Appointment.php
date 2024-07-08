<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Appointment extends Model
{
    use GlobalStatus;
    protected $guarded = [];

    public function appointmentStatus(): Attribute
    {
        return new Attribute(function () {
            if ($this->status == Status::COMPLETED_APPOINTMENT) {
                return '<span class="badge badge--success">' . trans('Completed') . '</span>';
            } elseif ($this->status == Status::CANCELLED_APPOINTMENT) {
                return '<span class="badge badge--danger">' . trans('Cancelled') . '</span>';
            } else {
                return '<span class="badge badge--warning">' . trans('Pending') . '</span>';
            }
        });
    }
}
