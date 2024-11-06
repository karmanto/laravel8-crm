<?php

namespace App\Http\Controllers;

use App\Models\ChatbotSchedule;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ChatbotScheduleController extends Controller
{
    public function index()
    {
        $chatbots = ChatbotSchedule::where('user_id', auth()->id())->get();
        return view('chatbots.index', compact('chatbots'));
    }
}
