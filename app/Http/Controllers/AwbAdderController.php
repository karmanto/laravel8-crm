<?php

namespace App\Http\Controllers;

use App\Models\AwbAdder;
use Illuminate\Http\Request;

class AwbAdderController extends Controller
{
    public function index()
    {
        $awbAdders = AwbAdder::where('user_id', auth()->id())->get();
        return view('awbAdders.index', compact('awbAdders'));
    }

    public function create()
    {
        return view('awbAdders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'trigger_message' => 'required|string',
            'trigger_from' => 'required|integer',
            'awb_field' => 'required|string',
            'logistic_field' => 'required|string',
        ]);

        AwbAdder::create([
            'user_id' => auth()->id(),
            'trigger_message' => $request->trigger_message,
            'trigger_from' => $request->trigger_from,
            'awb_field' => $request->awb_field,
            'logistic_field' => $request->logistic_field,
        ]);

        return redirect()->route('awbAdders.index')->with('success', 'adder awb berhasil ditambahkan.');
    }

    public function edit(AwbAdder $awbAdder)
    {
        $this->authorize('update', $awbAdder);

        return view('awbAdders.edit', compact('awbAdder'));
    }

    public function update(Request $request, AwbAdder $awbAdder)
    {
        $this->authorize('update', $awbAdder);

        $request->validate([
            'trigger_message' => 'required|string',
            'trigger_from' => 'required|integer',
            'awb_field' => 'required|string',
            'logistic_field' => 'required|string',
        ]);

        $awbAdder->update([
            'trigger_message' => $request->trigger_message,
            'trigger_from' => $request->trigger_from,
            'awb_field' => $request->awb_field,
            'logistic_field' => $request->logistic_field,
        ]);

        return redirect()->route('awbAdders.index')->with('success', 'adder awb berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $awbAdder = AwbAdder::findOrFail($id);

        $this->authorize('delete', $awbAdder);
        
        $awbAdder->delete();

        return redirect()->route('awbAdders.index')->with('success', 'adder awb berhasil dihapus.');
    }
}
