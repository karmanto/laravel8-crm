<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Awb;

class AwbController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $customers = Customer::where('user_id', $user->id)->get();
        $logistics = Logistic::all();
        $customerIds = $customers->pluck('id')->toArray();
        $query = Awb::whereIn('customer_id', $customerIds);

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
    
        if ($request->filled('logistic_id')) {
            $query->where('logistic_id', $request->logistic_id);
        }

        $awbs = $query->paginate(10);

        return view('awbs.index', compact('awbs', 'customers', 'logistics'));
    }
}


