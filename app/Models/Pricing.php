<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use GlobalStatus;
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class, 'pricing_id');
    }
    public function deposit()
    {
        return $this->hasMany(Deposit::class, 'pricing_id');
    }


}
