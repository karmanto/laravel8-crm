<?php

namespace App\Http\Controllers;

use App\Models\CustomerAdder;
use Illuminate\Http\Request;

class CustomerAdderController extends Controller
{
    public function index()
    {
        $customerAdders = CustomerAdder::where('user_id', auth()->id())->get();
        return view('customerAdders.index', compact('customerAdders'));
    }

    public function create()
    {
        return view('customerAdders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'trigger_message' => 'required|string',
            'trigger_from' => 'required|string',
        ]);

        CustomerAdder::create([
            'user_id' => auth()->id(),
            'trigger_message' => $request->trigger_message,
            'trigger_from' => $request->trigger_from,
        ]);

        return redirect()->route('customerAdders.index')->with('success', 'adder customer berhasil ditambahkan.');
    }

    public function edit(CustomerAdder $customerAdder)
    {
        $this->authorize('update', $customerAdder);

        return view('customerAdders.edit', compact('customerAdder'));
    }

    public function update(Request $request, CustomerAdder $customerAdder)
    {
        $this->authorize('update', $customerAdder);

        $request->validate([
            'trigger_message' => 'required|string',
            'trigger_from' => 'required|string',
        ]);

        $customerAdder->update([
            'trigger_message' => $request->trigger_message,
            'trigger_from' => $request->trigger_from,
        ]);

        return redirect()->route('customerAdders.index')->with('success', 'adder customer berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $customerAdder = CustomerAdder::findOrFail($id);

        $this->authorize('delete', $customerAdder);
        
        $customerAdder->delete();

        return redirect()->route('customerAdders.index')->with('success', 'adder customer berhasil dihapus.');
    }
}
