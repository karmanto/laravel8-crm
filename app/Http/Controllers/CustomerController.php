<?php

namespace App\Http\Controllers;

use App\Models\ChatbotSchedule;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatbotWhatsapp;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::where('user_id', Auth::id());
        $user = auth()->user();
        $chatbots = ChatbotWhatsapp::where('user_id', $user->id)->get();
        $schedules = ChatbotSchedule::where('user_id', $user->id)->get();

        if ($request->filled('chatbot_whatsapp_id')) {
            $query->where('chatbot_whatsapp_id', $request->chatbot_whatsapp_id);
        }
    
        if ($request->filled('is_exception')) {
            $query->where('is_exception', $request->is_exception);
        }
    
        if ($request->filled('chatbot_schedule_id')) {
            $query->where('chatbot_schedule_id', $request->chatbot_schedule_id);
        }

        $customers = $query->paginate(10);

        return view('customers.index', compact('customers', 'chatbots', 'schedules'));
    }

    public function create()
    {
        $user = auth()->user();
        $chatbots = ChatbotWhatsapp::where('user_id', $user->id)->get();
        $schedules = ChatbotSchedule::where('user_id', $user->id)->get();

        return view('customers.create', compact('chatbots', 'schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => [
                'required',
                'string',
                'regex:/^[0-9]{7,15}$/',
                'unique:customers,whatsapp_number,NULL,id,user_id,' . Auth::id()
            ],
            'chatbot_whatsapp_id' => [
                'required_if:is_exception,false',
                'required_without:is_exception',
                'nullable',
                'exists:chatbot_whatsapps,id'
            ],
            'chatbot_schedule_id' => [
                'nullable',
                'exists:chatbot_schedules,id'
            ],
        ], [
            'whatsapp_number.unique' => 'Nomor WhatsApp ini sudah terdaftar untuk customer lain.',
        ]);

        $data = $request->all();

        if ($request->is_exception) {
            $data['chatbot_whatsapp_id'] = null;
            $data['chatbot_schedule_id'] = null;
            $data['schedule_send_after'] = null;
        } else {
            if ($request->filled('chatbot_schedule_id')) {
                $schedule = ChatbotSchedule::find($request->chatbot_schedule_id);
                $data['schedule_send_after'] = $schedule && $schedule->send_after ? now()->addSeconds($schedule->send_after) : null;
            } else {
                $data['schedule_send_after'] = null;
            }
        }

        Customer::create(array_merge($data, ['user_id' => Auth::id()]));

        return redirect()->route('customers.index')->with('success', 'Customer berhasil ditambahkan.');
    }

    public function edit(Customer $customer)
    {
        $this->authorize('update', $customer);

        $user = auth()->user();
        $chatbots = ChatbotWhatsapp::where('user_id', $user->id)->get();
        $schedules = ChatbotSchedule::where('user_id', $user->id)->get();
        return view('customers.edit', compact('customer', 'chatbots', 'schedules'));
    }

    public function update(Request $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp_number' => [
                'required',
                'string',
                'regex:/^[0-9]{7,15}$/',
                'unique:customers,whatsapp_number,' . $customer->id . ',id,user_id,' . Auth::id()
            ],
            'chatbot_whatsapp_id' => [
                'required_if:is_exception,false',
                'required_without:is_exception',
                'nullable',
                'exists:chatbot_whatsapps,id'
            ],
            'chatbot_schedule_id' => [
                'nullable',
                'exists:chatbot_schedules,id'
            ],
        ], [
            'whatsapp_number.unique' => 'Nomor WhatsApp ini sudah terdaftar untuk customer lain.',
        ]);

        $data = $request->all();

        if ($request->is_exception) {
            $data['chatbot_whatsapp_id'] = null;
            $data['chatbot_schedule_id'] = null;
            $data['schedule_send_after'] = null;
        } else {
            if ($request->filled('chatbot_schedule_id') && $request->chatbot_schedule_id != $customer->chatbot_schedule_id) {
                $schedule = ChatbotSchedule::find($request->chatbot_schedule_id);
                $data['schedule_send_after'] = $schedule && $schedule->send_after ? now()->addSeconds($schedule->send_after) : null;
            } else {
                $data['schedule_send_after'] = null;
            }
        }

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer berhasil dihapus.');
    }
}


