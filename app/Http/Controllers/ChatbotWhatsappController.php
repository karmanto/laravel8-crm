<?php

namespace App\Http\Controllers;

use App\Models\ChatbotWhatsapp;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ChatbotWhatsappController extends Controller
{
    public function index()
    {
        $chatbots = ChatbotWhatsapp::where('user_id', auth()->id())->get();
        return view('chatbots.index', compact('chatbots'));
    }

    public function create()
    {
        return view('chatbots.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'is_active' => 'required|boolean',
            'whatsapp_number' => 'required|regex:/^[0-9]+$/|unique:chatbot_whatsapps,whatsapp_number',
        ]);

        ChatbotWhatsapp::create([
            'user_id' => auth()->id(),
            'is_active' => $request->is_active,
            'whatsapp_number' => $request->whatsapp_number,
        ]);

        return redirect()->route('chatbots.index')->with('success', 'Chatbot berhasil ditambahkan.');
    }

    public function edit(ChatbotWhatsapp $chatbot)
    {
        $this->authorize('update', $chatbot);

        return view('chatbots.edit', compact('chatbot'));
    }

    public function update(Request $request, ChatbotWhatsapp $chatbot)
    {
        $this->authorize('update', $chatbot);

        $request->validate([
            'is_active' => 'required|boolean',
            'whatsapp_number' => 'required|regex:/^[0-9]+$/|unique:chatbot_whatsapps,whatsapp_number,' . $chatbot->id,
        ]);

        $chatbot->update([
            'is_active' => $request->is_active,
            'whatsapp_number' => $request->whatsapp_number,
        ]);

        return redirect()->route('chatbots.index')->with('success', 'Chatbot WhatsApp berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $chatbot = ChatbotWhatsapp::findOrFail($id);

        $this->authorize('delete', $chatbot);

        $chatbot->qrcode = null;
        $chatbot->whatsapp_number = null;
        $chatbot->is_connect = false;
        $chatbot->is_active = false;

        $chatbot->save();
        
        $chatbot->delete();

        return redirect()->route('chatbots.index')->with('success', 'Chatbot berhasil dihapus.');
    }

    public function showQr($id)
    {
        $chatbot = ChatbotWhatsapp::findOrFail($id);
        
        $this->authorize('view', $chatbot);

        if (!$chatbot->qrcode) {
            return view('chatbots.show-Qr', compact('chatbot'));
        }
        
        $qrCodeImage = QrCode::size(300)->generate($chatbot->qrcode);
        
        return view('chatbots.show-Qr', compact('chatbot', 'qrCodeImage'));
    }

    public function checkAllStatus()
    {
        $chatbots = ChatbotWhatsapp::where('user_id', auth()->id())->get();

        $statuses = $chatbots->map(function ($chatbot) {
            return [
                'id' => $chatbot->id,
                'qrcode' => $chatbot->qrcode,
                'is_connect' => $chatbot->is_connect,
                'whatsapp_number' => $chatbot->whatsapp_number,
                'whatsapp_number_linked' => $chatbot->whatsapp_number_linked,
            ];
        });

        return response()->json($statuses);
    }
}
