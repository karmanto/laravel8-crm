<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AwbNotifier;
use App\Models\Awb;

class AwbController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $customers = Customer::where('user_id', $user->id)->get();
        $awbNotifiers = AwbNotifier::where('user_id', $user->id)->get();
        $logistics = Logistic::all();
        $customerIds = $customers->pluck('id')->toArray();
        $query = Awb::whereIn('customer_id', $customerIds);

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
    
        if ($request->filled('logistic_id')) {
            $query->where('logistic_id', $request->logistic_id);
        }
    
        if ($request->filled('awb_notifier_status_id')) {
            $query->where('awb_notifier_status_id', $request->awb_notifier_status_id);
        }

        $awbs = $query->paginate(10);

        return view('awbs.index', compact('awbs', 'customers', 'awbNotifiers', 'logistics'));
    }

    public function create()
    {
        $user = auth()->user();
        $customers = Customer::where('user_id', $user->id)->get();
        $awbNotifiers = AwbNotifier::where('user_id', $user->id)->get();
        $logistics = Logistic::all();

        return view('awbs.create', compact('customers', 'logistics', 'awbNotifiers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'awb_number' => 'required|string|max:255|unique:awbs,awb_number',
            'customer_id' => [
                'required',                        
                'exists:customers,id'    
            ],
            'awb_notifier_status_id' => [
                'nullable',                        
                'exists:awb_notifiers,id'    
            ],
            'logistic_id' => [
                'required',                        
                'exists:logistics,id'    
            ],
        ]);

        Awb::create($request->only('awb_number', 'customer_id', 'awb_notifier_status_id', 'logistic_id'));

        return redirect()->route('awbs.index')->with('success', 'Awb berhasil ditambahkan.');
    }

    public function edit(Awb $awb)
    {
        $this->authorize('update', $awb);

        $user = auth()->user();
        $customers = Customer::where('user_id', $user->id)->get();
        $awbNotifiers = AwbNotifier::where('user_id', $user->id)->get();
        $logistics = Logistic::all();

        return view('awbs.edit', compact('awb', 'customers', 'awbNotifiers', 'logistics'));
    }

    public function update(Request $request, Awb $awb)
    {
        $this->authorize('update', $awb);

        $request->validate([
            'awb_number' => 'required|string|max:255|unique:awbs,awb_number,' . $awb->id,
            'customer_id' => [
                'required',                        
                'exists:customers,id'    
            ],
            'awb_notifier_status_id' => [
                'nullable',                        
                'exists:awb_notifiers,id'    
            ],
            'logistic_id' => [
                'required',                        
                'exists:logistics,id'    
            ],
        ]);

        $awb->update($request->only('awb_number', 'customer_id', 'awb_notifier_status_id', 'logistic_id'));

        return redirect()->route('awbs.index')->with('success', 'Awb berhasil diperbarui.');
    }

    public function destroy(Awb $awb)
    {
        $this->authorize('delete', $awb);

        $awb->delete();

        return redirect()->route('awbs.index')->with('success', 'Awb berhasil dihapus.');
    }
}


