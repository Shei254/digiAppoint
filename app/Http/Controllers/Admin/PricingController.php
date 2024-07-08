<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pricing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PricingController extends Controller
{
    public function index()
    {
        $pageTitle = 'Pricing Plan';
        $pricing   = Pricing::orderBy('monthly_price')->get();
        return view('admin.pricing.index', compact('pageTitle', 'pricing'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name'                      => 'required',
            'monthly_price'             => 'required|numeric|gte:0',
            'yearly_price'              => 'required|numeric|gt:monthly_price',
            'staff_limit'               => 'required|numeric|gte:0',
            'daily_appointment_limit'   => 'required|integer|gte:0',
            'monthly_appointment_limit' => 'required|integer|gt:daily_appointment_limit',
        ]);

        if ($id) {
            $pricing      = Pricing::findOrFail($id);
            $notification = 'Pricing updated successfully';
        } else {
            $pricing      = new Pricing();
            $notification = 'Pricing added successfully';
        }

        $pricing->name                      = $request->name;
        $pricing->monthly_price             = $request->monthly_price;
        $pricing->yearly_price              = $request->yearly_price;
        $pricing->staff_limit               = $request->staff_limit;
        $pricing->daily_appointment_limit   = $request->daily_appointment_limit;
        $pricing->monthly_appointment_limit = $request->monthly_appointment_limit;
        $pricing->save();
        
        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Pricing::changeStatus($id);
    }
}
