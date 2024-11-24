<?php

namespace App\Http\Controllers;

use App\Models\ChatbotSchedule;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatbotWhatsapp;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::where('user_id', Auth::id());

        $customers = $query->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => [
                'required',
                'string',
                'regex:/^[0-9]{7,15}$/',
                'unique:customers,whatsapp_number,NULL,id,user_id,' . Auth::id()
            ],
            'age' => 'nullable|integer|between:5,100',
            'address' => 'nullable|string',
            'is_exception' => 'nullable|boolean',
        ], [
            'whatsapp_number.unique' => 'Nomor WhatsApp ini sudah terdaftar untuk customer lain.',
        ]);

        $data = $request->all();

        Customer::create(array_merge($data, ['user_id' => Auth::id()]));

        return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    public function edit(Customer $customer)
    {
        $this->authorize('update', $customer);

        $user = auth()->user();
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => [
                'required',
                'string',
                'regex:/^[0-9]{7,15}$/',
                'unique:customers,whatsapp_number,' . $customer->id . ',id,user_id,' . Auth::id()
            ],
            'age' => 'nullable|integer|between:5,100',
            'address' => 'nullable|string',
            'is_exception' => 'nullable|boolean',
        ], [
            'whatsapp_number.unique' => 'Nomor WhatsApp ini sudah terdaftar untuk customer lain.',
        ]);

        $data = $request->all();
        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus.');
    }
}


