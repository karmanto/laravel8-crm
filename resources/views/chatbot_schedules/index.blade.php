@extends('layouts.app-master')

@section('content')
<div class="bg-light p-5 rounded">
    <h1>Chatbot Schedule</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @php
        $updatedFields = session('updatedFields', []);
    @endphp

    @php
    $expandedGroups = [
        'groupWaktuGMT' => ['time_sending', 'gmt_time_sending'],
        'chatbot' => ['chatbot_closing', 'chatbot_repeat'],
        'trigger' => ['trigger_new_customer', 'trigger_order', 'name_pattern', 'awb_pattern', 'logistic_pattern', 'age_pattern', 'address_pattern', 'trigger_update_awb', 'total_order_pattern'],
        'followUp' => [
            'message_fu3', 
            'message_fu7', 
            'message_fu14', 
            'message_fu21', 
            'message_fu25', 
            'fu3_doc', 
            'fu7_doc', 
            'fu14_doc', 
            'fu21_doc', 
            'fu25_doc', 
        ],
        'resiGroup' => [
            'message_delivering',
            'message_in_kurir', 
            'message_delivered',
            'delivering_doc',
            'in_kurir_doc',
            'delivered_doc',
        ],
        'afterClosing' => [
            'message_fu3ac', 
            'message_fu7ac', 
            'message_fu14ac', 
            'message_fu21ac', 
            'message_fu25ac', 
            'fu3ac_doc', 
            'fu7ac_doc', 
            'fu14ac_doc', 
            'fu21ac_doc', 
            'fu25ac_doc', 
            'message_fu3ar', 
            'message_fu7ar', 
            'message_fu14ar', 
            'message_fu21ar', 
            'message_fu25ar', 
            'fu3ar_doc', 
            'fu7ar_doc', 
            'fu14ar_doc', 
            'fu21ar_doc', 
            'fu25ar_doc', 
        ],
    ];

    $isExpanded = fn($group) => !empty(array_intersect($updatedFields, $expandedGroups[$group] ?? []));
    @endphp

    <div class="container">
        <div>
            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="collapse" data-bs-target="#groupWaktuGMT">
                Waktu Perpesanan
            </button>
            <div id="groupWaktuGMT" class="collapse {{ $isExpanded('groupWaktuGMT') ? 'show' : '' }}">
                <table class="table table-bordered">
                    <tbody>
                        <tr style="background-color: skyBlue;">
                            <td>Waktu Pesan Dikirim</td>
                            <td>{{ $chatbotSchedule->time_sending }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalNumber" 
                                    data-field-title="Waktu Pesan Dikirim"
                                    data-field-name="time_sending" 
                                    data-field-value="{{ $chatbotSchedule->time_sending }}"
                                    data-field-min=0 
                                    data-field-max=23
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>

                        <tr style="background-color: skyBlue;">
                            <td>Patokan GMT</td>
                            <td>{{ $chatbotSchedule->gmt_time_sending }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalNumber" 
                                    data-field-title="Patokan GMT"
                                    data-field-name="gmt_time_sending" 
                                    data-field-value="{{ $chatbotSchedule->gmt_time_sending }}"
                                    data-field-min=-12 
                                    data-field-max=14
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="collapse" data-bs-target="#chatbot">
                Chatbot
            </button>
            <div id="chatbot" class="collapse {{ $isExpanded('chatbot') ? 'show' : '' }}">
                <table class="table table-bordered">
                    <tbody>
                        <tr style="background-color: skyBlue;">
                            <td>Chatbot Closing</td>
                            @php
                                $closingFound = false;
                            @endphp

                            @foreach($chatbots as $closing)
                                @if($chatbotSchedule->chatbot_closing == $closing->id)
                                    <td>{{ $closing->whatsapp_number }}</td>
                                    @php
                                        $closingFound = true;
                                    @endphp
                                @endif
                            @endforeach

                            @if(!$closingFound)
                                <td></td>
                            @endif
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalSelect" 
                                    data-field-title="Chatbot Closing"
                                    data-field-name="chatbot_closing"
                                    data-field-options='@json($chatbots->map(fn($c) => ["id" => $c->id, "name" => $c->whatsapp_number])->toArray())'
                                    data-field-value="{{ $chatbotSchedule->chatbot_closing }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>      
                        <tr><td colspan="3"></td></tr>      

                        <tr style="background-color: skyBlue;">
                            <td>Chatbot Repeat</td>
                            @php
                                $repeatFound = false;
                            @endphp

                            @foreach($chatbots as $repeat)
                                @if($chatbotSchedule->chatbot_repeat == $repeat->id)
                                    <td>{{ $repeat->whatsapp_number }}</td>
                                    @php
                                        $repeatFound = true;
                                    @endphp
                                @endif
                            @endforeach

                            @if(!$repeatFound)
                                <td></td>
                            @endif
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalSelect" 
                                    data-field-title="Chatbot Repeat"
                                    data-field-name="chatbot_repeat"
                                    data-field-options='@json($chatbots->map(fn($c) => ["id" => $c->id, "name" => $c->whatsapp_number])->toArray())'
                                    data-field-value="{{ $chatbotSchedule->chatbot_repeat }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr> 
                        <tr><td colspan="3"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="collapse" data-bs-target="#trigger">
                Trigger
            </button>
            <div 
            id="trigger" class="collapse {{ $isExpanded('trigger') ? 'show' : '' }}">
                <table class="table table-bordered">
                    <tbody>
                        <tr style="background-color: skyBlue;">
                            <td>Trigger New Customer</td>
                            <td style="white-space: pre-wrap;">{{ $chatbotSchedule->trigger_new_customer }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalText" 
                                    data-field-title="Trigger New Customer"
                                    data-field-name="trigger_new_customer" 
                                    data-field-value="{{ $chatbotSchedule->trigger_new_customer }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>

                        <tr style="background-color: skyBlue;">
                            <td>Trigger Order</td>
                            <td style="white-space: pre-wrap;">{{ $chatbotSchedule->trigger_order }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalText" 
                                    data-field-title="Trigger Order"
                                    data-field-name="trigger_order" 
                                    data-field-value="{{ $chatbotSchedule->trigger_order }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>

                        <tr style="background-color: skyBlue;">
                            <td>Name Pattern</td>
                            <td style="white-space: pre-wrap;">{{ $chatbotSchedule->name_pattern }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalText" 
                                    data-field-title="Name Pattern"
                                    data-field-name="name_pattern" 
                                    data-field-value="{{ $chatbotSchedule->name_pattern }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>
            
                        <tr style="background-color: skyBlue;">
                            <td>Age Pattern</td>
                            <td style="white-space: pre-wrap;">{{ $chatbotSchedule->age_pattern }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalText" 
                                    data-field-title="Age Pattern"
                                    data-field-name="age_pattern" 
                                    data-field-value="{{ $chatbotSchedule->age_pattern }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>
            
                        <tr style="background-color: skyBlue;">
                            <td>Address Pattern</td>
                            <td style="white-space: pre-wrap;">{{ $chatbotSchedule->address_pattern }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalText" 
                                    data-field-title="Address Pattern"
                                    data-field-name="address_pattern" 
                                    data-field-value="{{ $chatbotSchedule->address_pattern }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>

                        <tr style="background-color: skyBlue;">
                            <td>Total Order Pattern</td>
                            <td style="white-space: pre-wrap;">{{ $chatbotSchedule->total_order_pattern }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalText" 
                                    data-field-title="Total Order Pattern"
                                    data-field-name="total_order_pattern" 
                                    data-field-value="{{ $chatbotSchedule->total_order_pattern }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>

                        <tr style="background-color: skyBlue;">
                            <td>Trigger Update Resi</td>
                            <td style="white-space: pre-wrap;">{{ $chatbotSchedule->trigger_update_awb }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalText" 
                                    data-field-title="Trigger Update Resi"
                                    data-field-name="trigger_update_awb" 
                                    data-field-value="{{ $chatbotSchedule->trigger_update_awb }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>

                        <tr style="background-color: skyBlue;">
                            <td>Resi Pattern</td>
                            <td style="white-space: pre-wrap;">{{ $chatbotSchedule->awb_pattern }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalText" 
                                    data-field-title="Resi Pattern"
                                    data-field-name="awb_pattern" 
                                    data-field-value="{{ $chatbotSchedule->awb_pattern }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>

                        <tr style="background-color: skyBlue;">
                            <td>Logistic Pattern</td>
                            <td style="white-space: pre-wrap;">{{ $chatbotSchedule->logistic_pattern }}</td>
                            <td>
                                <button 
                                    class="btn btn-secondary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateModalText" 
                                    data-field-title="Logistic Pattern"
                                    data-field-name="logistic_pattern" 
                                    data-field-value="{{ $chatbotSchedule->logistic_pattern }}"
                                >
                                    Update
                                </button>
                            </td>
                        </tr>
                        <tr><td colspan="3"></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="collapse" data-bs-target="#followUp">
                Follow Up
            </button>
            <div id="followUp" class="collapse {{ $isExpanded('followUp') ? 'show' : '' }}">
                <table class="table table-bordered">
                    <tbody>
                        @php
                            $followUps = [
                                ['day' => 'H+3', 'message' => 'message_fu3', 'imageType' => 'fu3_doc'],
                                ['day' => 'H+7', 'message' => 'message_fu7', 'imageType' => 'fu7_doc'],
                                ['day' => 'H+14', 'message' => 'message_fu14', 'imageType' => 'fu14_doc'],
                                ['day' => 'H+21', 'message' => 'message_fu21', 'imageType' => 'fu21_doc'],
                                ['day' => 'H+25', 'message' => 'message_fu25', 'imageType' => 'fu25_doc'],
                            ];
                        @endphp

                        @foreach ($followUps as $followUp)
                            <tr style="background-color: skyblue;">
                                <td>Pesan Follow Up {{ $followUp['day'] }}</td>
                                <td style="white-space: pre-wrap;">{{ $chatbotSchedule->{$followUp['message']} }}</td>
                                <td>
                                    <button 
                                        class="btn btn-secondary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateModalText" 
                                        data-field-title="Pesan Follow Up {{ $followUp['day'] }}"
                                        data-field-name="{{ $followUp['message'] }}" 
                                        data-field-value="{{ $chatbotSchedule->{$followUp['message']} }}"
                                    >
                                        Update
                                    </button>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>

                            <tr style="background-color: skyblue;">
                                <td>Follow Up {{ $followUp['day'] }} File</td>
                                <td>
                                    @php
                                        $document = $chatbotSchedule->documents->firstWhere('type', $followUp['imageType']);
                                    @endphp

                                    @if ($document)
                                        <img src="{{ asset('storage/' . str_replace('public/', '', $document->filepath)) }}" alt="Follow Up {{ $followUp['day'] }} File" style="max-width: 100px;">
                                    @else
                                        No File
                                    @endif
                                </td>
                                <td>
                                    <button 
                                        class="btn btn-secondary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateModalFile" 
                                        data-field-title="Follow Up {{ $followUp['day'] }} File"
                                        data-field-name="{{ $followUp['imageType'] }}" 
                                    >
                                        Update
                                    </button>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="collapse" data-bs-target="#resiGroup">
                Update Resi
            </button>
            <div id="resiGroup" class="collapse {{ $isExpanded('resiGroup') ? 'show' : '' }}">
                <table class="table table-bordered">
                    <tbody>
                        @php
                            $resis = [
                                ['title' => 'Pesan Update Status Paket Terkirim', 'message' => 'message_delivering', 'imageType' => 'delivering_doc'],
                                ['title' => 'Pesan Update Status dibawa Kurir', 'message' => 'message_in_kurir', 'imageType' => 'in_kurir_doc'],
                                ['title' => 'Pesan Update Status Sampai Tujuan', 'message' => 'message_delivered', 'imageType' => 'delivered_doc'],
                            ];
                        @endphp

                        @foreach ($resis as $resi)
                            <tr style="background-color: skyblue;">
                                <td>{{ $resi['title'] }}</td>
                                <td style="white-space: pre-wrap;">{{ $chatbotSchedule->{$resi['message']} }}</td>
                                <td>
                                    <button 
                                        class="btn btn-secondary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateModalText" 
                                        data-field-title="{{ $resi['title'] }}"
                                        data-field-name="{{ $resi['message'] }}" 
                                        data-field-value="{{ $chatbotSchedule->{$resi['message']} }}"
                                    >
                                        Update
                                    </button>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>

                            <tr style="background-color: skyblue;">
                                <td>{{ $resi['title'] }} File</td>
                                <td>
                                    @php
                                        $document = $chatbotSchedule->documents->firstWhere('type', $resi['imageType']);
                                    @endphp

                                    @if ($document)
                                        <img src="{{ asset('storage/' . str_replace('public/', '', $document->filepath)) }}" alt="Follow Up {{ $resi['title'] }} File" style="max-width: 100px;">
                                    @else
                                        No File
                                    @endif
                                </td>
                                <td>
                                    <button 
                                        class="btn btn-secondary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateModalFile" 
                                        data-field-title="{{ $resi['title'] }} File"
                                        data-field-name="{{ $resi['imageType'] }}" 
                                    >
                                        Update
                                    </button>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="collapse" data-bs-target="#afterClosing">
                After Closing
            </button>
            <div id="afterClosing" class="collapse {{ $isExpanded('afterClosing') ? 'show' : '' }}">
                <table class="table table-bordered">
                    <tbody>
                        @php
                            $followUps = [
                                ['type' => 'ac', 'day' => 'H+3', 'message' => 'message_fu3ac', 'imageType' => 'fu3ac_doc'],
                                ['type' => 'ac', 'day' => 'H+7', 'message' => 'message_fu7ac', 'imageType' => 'fu7ac_doc'],
                                ['type' => 'ac', 'day' => 'H+14', 'message' => 'message_fu14ac', 'imageType' => 'fu14ac_doc'],
                                ['type' => 'ac', 'day' => 'H+21', 'message' => 'message_fu21ac', 'imageType' => 'fu21ac_doc'],
                                ['type' => 'ac', 'day' => 'H+25', 'message' => 'message_fu25ac', 'imageType' => 'fu25ac_doc'],
                                ['type' => 'ar', 'day' => 'H+3', 'message' => 'message_fu3ar', 'imageType' => 'fu3ar_doc'],
                                ['type' => 'ar', 'day' => 'H+7', 'message' => 'message_fu7ar', 'imageType' => 'fu7ar_doc'],
                                ['type' => 'ar', 'day' => 'H+14', 'message' => 'message_fu14ar', 'imageType' => 'fu14ar_doc'],
                                ['type' => 'ar', 'day' => 'H+21', 'message' => 'message_fu21ar', 'imageType' => 'fu21ar_doc'],
                                ['type' => 'ar', 'day' => 'H+25', 'message' => 'message_fu25ar', 'imageType' => 'fu25ar_doc'],
                            ];
                        @endphp

                        @foreach ($followUps as $followUp)
                            @php
                                $title = $followUp['type'] === 'ar' ? 'Repeat' : 'Closing';
                            @endphp

                            <tr style="background-color: skyBlue;">
                                <td>Pesan After {{ $title }} {{ $followUp['day'] }}</td>
                                <td style="white-space: pre-wrap;">{{ $chatbotSchedule->{$followUp['message']} }}</td>
                                <td>
                                    <button 
                                        class="btn btn-secondary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateModalText" 
                                        data-field-title="Pesan After {{ $title }} {{ $followUp['day'] }}"
                                        data-field-name="{{ $followUp['message'] }}" 
                                        data-field-value="{{ $chatbotSchedule->{$followUp['message']} }}"
                                    >
                                        Update
                                    </button>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>

                            <tr style="background-color: skyBlue;">
                                <td>After {{ $title }} {{ $followUp['day'] }} File</td>
                                <td>
                                    @php
                                        $document = $chatbotSchedule->documents->firstWhere('type', $followUp['imageType']);
                                    @endphp

                                    @if ($document)
                                        <img src="{{ asset('storage/' . str_replace('public/', '', $document->filepath)) }}" alt="After {{ $title }} {{ $followUp['day'] }} File" style="max-width: 100px;">
                                    @else
                                        No File
                                    @endif
                                </td>
                                <td>
                                    <button 
                                        class="btn btn-secondary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#updateModalFile" 
                                        data-field-title="After {{ $title }} {{ $followUp['day'] }} File"
                                        data-field-name="{{ $followUp['imageType'] }}" 
                                    >
                                        Update
                                    </button>
                                </td>
                            </tr>
                            <tr><td colspan="3"></td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Template Number-->
<div class="modal fade" id="updateModalNumber" tabindex="-1" aria-labelledby="updateModalNumberLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateNumberForm" method="POST" action="{{ route('chatbot-schedules.update', $chatbotSchedule->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalNumberLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fieldNumber" class="form-label">New Value</label>
                        <input type="number" class="form-control" id="fieldNumber" name="value" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Template Select-->
<div class="modal fade" id="updateModalSelect" tabindex="-1" aria-labelledby="updateModalSelectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateSelectForm" method="POST" action="{{ route('chatbot-schedules.update', $chatbotSchedule->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalSelectLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fieldSelect" class="form-label">New Value</label>
                        <select class="form-select" id="fieldSelect" name="value"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Template Text-->
<div class="modal fade" id="updateModalText" tabindex="-1" aria-labelledby="updateModalTextLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updateTextForm" method="POST" action="{{ route('chatbot-schedules.update', $chatbotSchedule->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalTextLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fieldText" class="form-label">New Value</label>
                        <textarea class="form-control" id="fieldText" name="value" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Template File Upload -->
<div class="modal fade" id="updateModalFile" tabindex="-1" aria-labelledby="updateModalFileLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="fileUploadForm" method="POST" action="{{ route('chatbot-schedules.update', $chatbotSchedule->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalFileLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fieldFile" class="form-label">Upload File</label>
                        <input type="file" class="form-control" id="fieldFile" name="value" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var updateModalNumber = document.getElementById('updateModalNumber');
        var updateModalSelect = document.getElementById('updateModalSelect');
        var updateModalText = document.getElementById('updateModalText');
        var updateModalFile = document.getElementById('updateModalFile');

        updateModalNumber.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var fieldName = button.getAttribute('data-field-name');
            var fieldTitle = button.getAttribute('data-field-title');
            var fieldValue = button.getAttribute('data-field-value');
            var fieldMin = button.getAttribute('data-field-min');
            var fieldMax = button.getAttribute('data-field-max');

            var fieldValueInput = updateModalNumber.querySelector('#fieldNumber');
            var modalTitle = updateModalNumber.querySelector('#updateModalNumberLabel');
            
            fieldValueInput.setAttribute('name', fieldName);
            fieldValueInput.value = fieldValue || ''; 
            
            if (fieldMin !== null) {
                fieldValueInput.setAttribute('min', fieldMin);
            } else {
                fieldValueInput.removeAttribute('min');
            }

            if (fieldMax !== null) {
                fieldValueInput.setAttribute('max', fieldMax);
            } else {
                fieldValueInput.removeAttribute('max');
            }

            modalTitle.textContent = 'Update ' + fieldTitle;
        });

        updateModalSelect.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var fieldTitle = button.getAttribute('data-field-title');
            var fieldName = button.getAttribute('data-field-name');
            var fieldValue = button.getAttribute('data-field-value');
            var fieldOptions = JSON.parse(button.getAttribute('data-field-options')); 
            var modalTitle = updateModalSelect.querySelector('#updateModalSelectLabel');
            var fieldSelect = updateModalSelect.querySelector('#fieldSelect');
            modalTitle.textContent = 'Update ' + fieldTitle;
            fieldSelect.innerHTML = '';

            fieldOptions.forEach(function (option) {
                var optionElement = document.createElement('option');
                optionElement.value = option.id;
                optionElement.textContent = option.name;

                if (fieldValue == option.id) {
                    optionElement.selected = true;
                }

                fieldSelect.appendChild(optionElement);
            });

            fieldSelect.setAttribute('name', fieldName);
        });

        updateModalText.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var fieldName = button.getAttribute('data-field-name');
            var fieldTitle = button.getAttribute('data-field-title');
            var fieldValue = button.getAttribute('data-field-value');

            var fieldValueInput = updateModalText.querySelector('#fieldText');
            var modalTitle = updateModalText.querySelector('#updateModalTextLabel');
            
            fieldValueInput.setAttribute('name', fieldName);
            fieldValueInput.value = fieldValue || ''; 

            modalTitle.textContent = 'Update ' + fieldTitle;
        });

        updateModalFile.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; 
            var fieldName = button.getAttribute('data-field-name');
            var fieldTitle = button.getAttribute('data-field-title');

            var fieldValueInput = updateModalFile.querySelector('#fieldFile');
            var modalTitle = updateModalFile.querySelector('#updateModalFileLabel');
            
            fieldValueInput.setAttribute('name', fieldName);

            modalTitle.textContent = 'Update ' + fieldTitle;
        });
    });

</script>
@endsection
