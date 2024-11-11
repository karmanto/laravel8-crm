<?php

namespace App\Http\Controllers;

use App\Models\ChatbotSchedule;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChatbotScheduleController extends Controller
{
    public function index()
    {
        $chatbotSchedules = ChatbotSchedule::where('user_id', auth()->id())->with('documents')->get();
        return view('chatbot_schedules.index', compact('chatbotSchedules'));
    }

    public function create()
    {
        return view('chatbot_schedules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required',
            'trigger_message' => 'required',
            'trigger_from' => 'required|integer',
            'send_after' => 'required|integer',
            'documents.*' => 'file|mimes:jpg,jpeg,png|max:2048'
        ]);

        $chatbotSchedule = ChatbotSchedule::create([
            'user_id' => auth()->id(), 
            'name' => $request->name,
            'description' => $request->description,
            'message' => $request->message,
            'trigger_message' => $request->trigger_message,
            'trigger_from' => $request->trigger_from,
            'send_after' => $request->send_after,
        ]);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filePath = $file->store('public');
                Document::create([
                    'chatbot_schedule_id' => $chatbotSchedule->id,
                    'name' => $file->getClientOriginalName(),
                    'filepath' => $filePath,
                ]);
            }
        }

        return redirect()->route('chatbot-schedules.index')->with('success', 'Chatbot Schedule created successfully.');
    }

    public function show(ChatbotSchedule $chatbotSchedule)
    {
        $this->authorize('view', $chatbotSchedule);

        $chatbotSchedule->load('documents');
        return view('chatbot_schedules.show', compact('chatbotSchedule'));
    }

    public function edit(ChatbotSchedule $chatbotSchedule)
    {
        $this->authorize('update', $chatbotSchedule);

        $chatbotSchedule->load('documents');
        return view('chatbot_schedules.edit', compact('chatbotSchedule'));
    }

    public function update(Request $request, ChatbotSchedule $chatbotSchedule)
    {
        $this->authorize('update', $chatbotSchedule);

        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required',
            'trigger_message' => 'required',
            'trigger_from' => 'required|integer',
            'send_after' => 'required|integer',
            'documents.*' => 'file|mimes:jpg,jpeg,png|max:2048'
        ]);

        $chatbotSchedule->update($request->only([
            'name', 'description', 'message', 'trigger_message', 'trigger_from', 'send_after'
        ]));

        if ($request->hasFile('documents')) {
            foreach ($chatbotSchedule->documents as $document) {
                Storage::delete($document->filepath);
                $document->delete(); 
            }

            foreach ($request->file('documents') as $file) {
                $filePath = $file->store('public');

                Document::create([
                    'chatbot_schedule_id' => $chatbotSchedule->id,
                    'name' => $file->getClientOriginalName(),
                    'filepath' => $filePath,
                ]);
            }
        }

        return redirect()->route('chatbot-schedules.index')->with('success', 'Chatbot Schedule updated successfully.');
    }

    public function destroy(ChatbotSchedule $chatbotSchedule)
    {
        $this->authorize('delete', $chatbotSchedule);
        $chatbotSchedule->delete();
        return redirect()->route('chatbot-schedules.index')->with('success', 'Chatbot Schedule deleted successfully.');
    }
}
