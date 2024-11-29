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
            'awb_pattern' => 'sometimes|string',
            'logistic_pattern' => 'sometimes|string',
            'age_pattern' => 'sometimes|string',
            'address_pattern' => 'sometimes|string',
            'total_order_pattern' => 'sometimes|string',
            'trigger_update_awb' => 'sometimes|string',
            'message_delivering' => 'sometimes|string',
            'message_in_kurir' => 'sometimes|string',
            'message_delivered' => 'sometimes|string',
            'message_fu3ac' => 'sometimes|string',
            'message_fu7ac' => 'sometimes|string',
            'message_fu14ac' => 'sometimes|string',
            'message_fu21ac' => 'sometimes|string',
            'message_fu25ac' => 'sometimes|string',
            'message_fu3ar' => 'sometimes|string',
            'message_fu7ar' => 'sometimes|string',
            'message_fu14ar' => 'sometimes|string',
            'message_fu21ar' => 'sometimes|string',
            'message_fu25ar' => 'sometimes|string',
        ]);

        // Simpan data asli sebelum update
        $originalData = $chatbotSchedule->only(array_keys($validatedData));

        // Lakukan update data
        $chatbotSchedule->update($validatedData);

        // Tentukan field yang berubah
        $updatedFields = [];
        foreach ($validatedData as $key => $value) {
            if ($originalData[$key] !== $value) {
                $updatedFields[] = $key;
            }
        }

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
            'fu3ar_doc',
            'fu7ar_doc',
            'fu14ar_doc',
            'fu21ar_doc',
            'fu25ar_doc',
            'delivering_doc',
            'in_kurir_doc',
            'delivered_doc',
        ];

        foreach ($documentTypes as $field) {
            if ($request->hasFile($field)) {
                $request->validate([
                    $field => [
                        'required',
                        'file',
                        'mimes:jpg,jpeg,png,mp4,mov,avi',
                        function ($attribute, $value, $fail) {
                            $maxSize = 0;
                
                            $mimeType = $value->getMimeType();
                            if (str_starts_with($mimeType, 'image/')) {
                                $maxSize = 2048; 
                            } elseif (str_starts_with($mimeType, 'video/')) {
                                $maxSize = 16000; 
                            }
                
                            if ($value->getSize() > $maxSize * 1024) {
                                $fail("$attribute exceeds the maximum size of $maxSize KB.");
                            }
                        },
                    ],
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

                $updatedFields[] = $field;
            } else {
                $existingDocument = Document::where('chatbot_schedule_id', $chatbotSchedule->id)
                    ->where('type', $field)
                    ->first();

                if ($existingDocument) {
                    Storage::delete($existingDocument->filepath);
                    $existingDocument->delete();
                    $updatedFields[] = $field;
                }
            }
        }

        return back()->with('success', 'Chatbot schedule updated successfully!')->with('updatedFields', $updatedFields);
    }
}
