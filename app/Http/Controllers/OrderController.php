<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Awb;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($request->filled('customer_id')) {
            $customers = Customer::where('user_id', $user->id)
            ->where('id', $request->customer_id)
            ->select('id', 'whatsapp_number', 'name') 
            ->get();
        } else {
            $customers = Customer::where('user_id', $user->id)
            ->select('id', 'whatsapp_number', 'name') 
            ->get();
        }

        $logistics = Logistic::all();
        $customerIds = $customers->pluck('id')->toArray();
        $query = Order::whereIn('customer_id', $customerIds);

        $orders = $query->paginate(25);

        return view('orders.index', compact('orders', 'customers', 'logistics'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        if ($request->filled('customer_id')) {
            $customers = Customer::where('user_id', $user->id)
            ->where('id', $request->customer_id)
            ->select('id', 'whatsapp_number', 'name') 
            ->get();
        } else {
            $customers = Customer::where('user_id', $user->id)
            ->select('id', 'whatsapp_number', 'name') 
            ->get();
        }

        $logistics = Logistic::all();

        return view('orders.create', compact('customers', 'logistics'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'nullable|string|max:25',
            'from' => 'required|string|max:25',
            'total_order' => 'required|numeric',
            'customer_id' => [
                'required',                        
                'exists:customers,id'    
            ],
            'awb_number' => 'nullable|string|max:255|unique:awbs,awb_number', 
            'logistic_id' => 'required_with:awb_number|nullable|exists:logistics,id',
        ]);

        $order = Order::create($request->only('status', 'from', 'total_order', 'customer_id'));

        if ($request->filled('awb_number')) {
            $awb = Awb::create([
                'awb_number' => $request->awb_number,
                'customer_id' => $request->customer_id,
                'logistic_id' => $request->logistic_id,
            ]);

            $order->awb_id = $awb->id;
            $order->save();
        }

        return redirect()->route('orders.index')->with('success', 'Order berhasil ditambahkan.');
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);

        $user = auth()->user();

        $customer = Customer::where('user_id', $user->id)
            ->where('id', $order->customer_id) 
            ->select('id', 'whatsapp_number', 'name')
            ->firstOrFail();

        $logistics = Logistic::all();

        return view('orders.edit', compact('order', 'customer', 'logistics'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $request->validate([
            'status' => 'nullable|string|max:25',
            'from' => 'required|string|max:25',
            'total_order' => 'required|numeric',
            'customer_id' => [
                'required',                        
                'exists:customers,id'    
            ],
            'awb_number' => 'nullable|string|max:255|unique:awbs,awb_number,' . optional($order->awb)->id, 
            'logistic_id' => 'required_with:awb_number|nullable|exists:logistics,id',
        ]);

        $order->update($request->only('status', 'from', 'total_order', 'customer_id'));

        if ($request->filled('awb_number')) {
            if ($order->awb) {
                $order->awb->update([
                    'awb_number' => $request->awb_number,
                    'customer_id' => $request->customer_id,
                    'logistic_id' => $request->logistic_id,
                ]);
            } else {
                $awb = Awb::create([
                    'awb_number' => $request->awb_number,
                    'customer_id' => $request->customer_id,
                    'logistic_id' => $request->logistic_id,
                ]);

                $order->awb_id = $awb->id;
                $order->save();
            }
        }

        return redirect()->route('orders.index')->with('success', 'Order berhasil diperbarui.');
    }
}
