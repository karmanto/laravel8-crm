<?php

namespace App\Http\Controllers;

use App\Models\ChatbotSchedule;
use App\Models\ChatbotWhatsapp;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ChatbotScheduleController extends Controller
{
    public function index()
    {
        $chatbotSchedule = ChatbotSchedule::where('user_id', auth()->id())->first();
        $chatbots = ChatbotWhatsapp::where('user_id', auth()->id())->get();
        return view('chatbot_schedules.index', compact('chatbotSchedule', 'chatbots'));
    }

    public function update(Request $request, ChatbotSchedule $chatbotSchedule)
    {
        $this->authorize('update', $chatbotSchedule);

        $validatedData = $request->validate([
            'time_sending' => 'sometimes|integer|between:0,23',
            'gmt_time_sending' => 'sometimes|integer|between:-12,14',
            'chatbot_closing' => [
                'sometimes',
                Rule::exists('chatbot_whatsapps', 'id')->where('user_id', auth()->id()),
            ],
            'chatbot_repeat' => [
                'sometimes',
                Rule::exists('chatbot_whatsapps', 'id')->where('user_id', auth()->id()),
            ],
            'trigger_new_customer' => 'sometimes|string',
            'message_fu3' => 'sometimes|string',
            'message_fu7' => 'sometimes|string',
            'message_fu14' => 'sometimes|string',
            'message_fu21' => 'sometimes|string',
            'message_fu25' => 'sometimes|string',
            'trigger_order' => 'sometimes|string',
            'message_update_awb' => 'sometimes|string',
            'message_in_kurir' => 'sometimes|string',
            'message_delivered' => 'sometimes|string',
            'message_fu3ac' => 'sometimes|string',
            'message_fu7ac' => 'sometimes|string',
            'message_fu14ac' => 'sometimes|string',
            'message_fu21ac' => 'sometimes|string',
            'message_fu25ac' => 'sometimes|string',
            'message_fu14ar' => 'sometimes|string',
            'message_fu25ar' => 'sometimes|string',
        ]);

        $documentTypes = [
            'fu3_doc',
            'fu7_doc',
            'fu14_doc',
            'fu21_doc',
            'fu25_doc',
            'fu3ac_doc',
            'fu7ac_doc',
            'fu14ac_doc',
            'fu21ac_doc',
            'fu25ac_doc',
            'fu14ar_doc',
            'fu25ar_doc',
        ];

        foreach ($documentTypes as $field) {
            if ($request->hasFile($field)) {
                $request->validate([
                    $field => 'sometimes|file|mimes:jpg,jpeg,png|max:2048',
                ]);

                $file = $request->file($field);
                $filePath = $file->store('public');  
                
                $existingDocument = Document::where('chatbot_schedule_id', $chatbotSchedule->id)
                    ->where('type', $field)
                    ->first();

                if ($existingDocument) {
                    Storage::delete($existingDocument->filepath);
                    $existingDocument->delete();
                }

                Document::create([
                    'chatbot_schedule_id' => $chatbotSchedule->id,
                    'name' => $file->getClientOriginalName(),
                    'filepath' => $filePath,
                    'type' => $field,
                ]);
            } else {
                $existingDocument = Document::where('chatbot_schedule_id', $chatbotSchedule->id)
                    ->where('type', $field)
                    ->first();
        
                if ($existingDocument) {
                    Storage::delete($existingDocument->filepath);
                    $existingDocument->delete();
                }
            }
        }

        $chatbotSchedule->update($validatedData);

        return back()->with('success', 'Chatbot schedule updated successfully!');
    }
}
