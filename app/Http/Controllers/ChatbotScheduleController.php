<?php

namespace App\Http\Controllers;

use App\Models\ChatbotSchedule;

class ChatbotScheduleController extends Controller
{
    public function index()
    {
        $schedules = ChatbotSchedule::where('user_id', auth()->id())->get();
        return view('schedules.index', compact('schedules'));
    }
}
