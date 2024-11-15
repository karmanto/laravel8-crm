<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ChatbotWhatsapp;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        if (auth()->user()->is_admin) {
            $user->is_active = !$user->is_active;
            $user->save();
            return redirect()->back()->with('success', 'Status user berhasil diubah.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah status.');
    }

    public function updateChatbotWhatsappCount(Request $request, User $user)
    {
        if (auth()->user()->is_admin) {
            $request->validate([
                'chatbot_whatsapp_count' => 'required|integer|min:0',
            ]);

            $inputCount = $request->input('chatbot_whatsapp_count');
            $currentChatbotCount = ChatbotWhatsapp::where('user_id', $user->id)->count();

            if ($currentChatbotCount > $inputCount) {
                return redirect()->back()->withErrors([
                    'chatbot_whatsapp_count' => 'Jumlah Chatbot WhatsApp yang ada melebihi jumlah yang diinput.'
                ]);
            }

            $user->chatbot_whatsapp_count = $inputCount;
            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'Jumlah Chatbot WhatsApp berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah jumlah chatbot WhatsApp.');
    }
}
