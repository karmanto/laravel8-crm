<?php

namespace App\Http\Controllers;

use App\Models\AwbNotifier;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AwbNotifierController extends Controller
{
    public function index()
    {
        $awbNotifiers = AwbNotifier::with('documents')->get();
        return view('awb_notifiers.index', compact('awbNotifiers'));
    }

    public function create()
    {
        return view('awb_notifiers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required',
            'trigger_awb_status' => 'required',
            'documents.*' => 'file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $awbNotifier = AwbNotifier::create([
            'user_id' => auth()->id(), 
            'name' => $request->name,
            'description' => $request->description,
            'message' => $request->message,
            'trigger_awb_status' => $request->trigger_awb_status,
        ]);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filePath = $file->store('public');
                Document::create([
                    'awb_notifier_id' => $awbNotifier->id,
                    'name' => $file->getClientOriginalName(),
                    'filepath' => $filePath,
                ]);
            }
        }

        return redirect()->route('awb-notifiers.index')->with('success', 'AWB Notifier created successfully.');
    }

    public function show(AwbNotifier $awbNotifier)
    {
        $this->authorize('view', $awbNotifier);

        $awbNotifier->load('documents');
        return view('awb_notifiers.show', compact('awbNotifier'));
    }

    public function edit(AwbNotifier $awbNotifier)
    {
        $this->authorize('update', $awbNotifier);

        $awbNotifier->load('documents');
        return view('awb_notifiers.edit', compact('awbNotifier'));
    }

    public function update(Request $request, AwbNotifier $awbNotifier)
    {
        $this->authorize('update', $awbNotifier);

        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required',
            'trigger_awb_status' => 'required',
            'documents.*' => 'file|mimes:jpg,jpeg,png|max:2048', 
        ]);

        $awbNotifier->update($request->only([
            'name', 'description', 'message', 'trigger_awb_status'
        ]));

        if ($request->hasFile('documents')) {
            foreach ($awbNotifier->documents as $document) {
                Storage::delete($document->filepath);
                $document->delete(); 
            }

            foreach ($request->file('documents') as $file) {
                $filePath = $file->store('public');

                Document::create([
                    'chatbot_schedule_id' => $awbNotifier->id,
                    'name' => $file->getClientOriginalName(),
                    'filepath' => $filePath,
                ]);
            }
        }

        return redirect()->route('awb-notifiers.index')->with('success', 'AWB Notifier updated successfully.');
    }

    public function destroy(AwbNotifier $awbNotifier)
    {
        $this->authorize('delete', $awbNotifier);

        $awbNotifier->delete();

        return redirect()->route('awb-notifiers.index')->with('success', 'AWB Notifier deleted successfully.');
    }
}
