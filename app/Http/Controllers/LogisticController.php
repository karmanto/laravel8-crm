<?php

namespace App\Http\Controllers;

use App\Models\Logistic;
use Illuminate\Http\Request;

class LogisticController extends Controller
{
    public function index()
    {
        $logistics = Logistic::all();

        return view('logistics.index', compact('logistics'));
    }

    public function create()
    {
        return view('logistics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Logistic::create($request->only('name'));

        return redirect()->route('logistics.index')->with('success', 'Logistic berhasil ditambahkan.');
    }

    public function edit(Logistic $logistic)
    {
        return view('logistics.edit', compact('logistic'));
    }

    public function update(Request $request, Logistic $logistic)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $logistic->update($request->only('name'));

        return redirect()->route('logistics.index')->with('success', 'Logistic berhasil diperbarui.');
    }

    public function destroy(Logistic $logistic)
    {
        $logistic->delete();

        return redirect()->route('logistics.index')->with('success', 'Logistic berhasil dihapus.');
    }
}
