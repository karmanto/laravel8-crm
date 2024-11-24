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

    <table class="table">
        <thead>
            <tr>
                <th>Field Name</th>
                <th>Value</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: Pink;">
                <td>Waktu Pengiriman Pesan</td>
                <td>{{ $chatbotSchedule->time_sending }}</td>
                <td>
                    <button 
                        class="btn btn-secondary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#updateModalNumber" 
                        data-field-title="Waktu Pengiriman Pesan"
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

            <tr style="background-color: Pink;">
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

            <tr style="background-color: lightyellow;">
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

            <tr style="background-color: lightyellow;">
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

            <tr style="background-color: LightCoral;">
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
                    <td>Follow Up {{ $followUp['day'] }} Image</td>
                    <td>
                        @php
                            $document = $chatbotSchedule->documents->firstWhere('type', $followUp['imageType']);
                        @endphp

                        @if ($document)
                            <img src="{{ asset('storage/' . str_replace('public/', '', $document->filepath)) }}" alt="Follow Up {{ $followUp['day'] }} Image" style="max-width: 100px;">
                        @else
                            No image
                        @endif
                    </td>
                    <td>
                        <button 
                            class="btn btn-secondary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#updateModalFile" 
                            data-field-title="Follow Up {{ $followUp['day'] }} Image"
                            data-field-name="{{ $followUp['imageType'] }}" 
                        >
                            Update
                        </button>
                    </td>
                </tr>
                <tr><td colspan="3"></td></tr>
            @endforeach

            <tr style="background-color: LightCoral;">
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

            <tr style="background-color: lightgreen;">
                <td>Pesan Update Resi</td>
                <td style="white-space: pre-wrap;">{{ $chatbotSchedule->message_update_awb }}</td>
                <td>
                    <button 
                        class="btn btn-secondary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#updateModalText" 
                        data-field-title="Pesan Update Resi"
                        data-field-name="message_update_awb" 
                        data-field-value="{{ $chatbotSchedule->message_update_awb }}"
                    >
                        Update
                    </button>
                </td>
            </tr>
            <tr><td colspan="3"></td></tr>

            <tr style="background-color: lightgreen;">
                <td>Pesan Update Status dibawa Kurir</td>
                <td style="white-space: pre-wrap;">{{ $chatbotSchedule->message_in_kurir }}</td>
                <td>
                    <button 
                        class="btn btn-secondary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#updateModalText" 
                        data-field-title="Pesan Update Status dibawa Kurir"
                        data-field-name="message_in_kurir" 
                        data-field-value="{{ $chatbotSchedule->message_in_kurir }}"
                    >
                        Update
                    </button>
                </td>
            </tr>
            <tr><td colspan="3"></td></tr>

            <tr style="background-color: lightgreen;">
                <td>Pesan Update Status Sampai Tujuan</td>
                <td style="white-space: pre-wrap;">{{ $chatbotSchedule->message_delivered }}</td>
                <td>
                    <button 
                        class="btn btn-secondary" 
                        data-bs-toggle="modal" 
                        data-bs-target="#updateModalText" 
                        data-field-title="Pesan Update Status Sampai Tujuan"
                        data-field-name="message_delivered" 
                        data-field-value="{{ $chatbotSchedule->message_delivered }}"
                    >
                        Update
                    </button>
                </td>
            </tr>
            <tr><td colspan="3"></td></tr>

            @php
                $followUps = [
                    ['type' => 'ac', 'day' => 'H+3', 'message' => 'message_fu3ac', 'imageType' => 'fu3ac_doc'],
                    ['type' => 'ac', 'day' => 'H+7', 'message' => 'message_fu7ac', 'imageType' => 'fu7ac_doc'],
                    ['type' => 'ac', 'day' => 'H+14', 'message' => 'message_fu14ac', 'imageType' => 'fu14ac_doc'],
                    ['type' => 'ac', 'day' => 'H+21', 'message' => 'message_fu21ac', 'imageType' => 'fu21ac_doc'],
                    ['type' => 'ac', 'day' => 'H+25', 'message' => 'message_fu25ac', 'imageType' => 'fu25ac_doc'],
                    ['type' => 'ar', 'day' => 'H+14', 'message' => 'message_fu14ar', 'imageType' => 'fu14ar_doc'],
                    ['type' => 'ar', 'day' => 'H+25', 'message' => 'message_fu25ar', 'imageType' => 'fu25ar_doc'],
                ];
            @endphp

            @foreach ($followUps as $followUp)
                @php
                    $bgColor = $followUp['type'] === 'ar' ? 'honeydew' : 'Lavender';
                    $title = $followUp['type'] === 'ar' ? 'Repeat' : 'Closing';
                @endphp

                <tr style="background-color: {{ $bgColor }};">
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

                <tr style="background-color: {{ $bgColor }};">
                    <td>After {{ $title }} {{ $followUp['day'] }} Image</td>
                    <td>
                        @php
                            $document = $chatbotSchedule->documents->firstWhere('type', $followUp['imageType']);
                        @endphp

                        @if ($document)
                            <img src="{{ asset('storage/' . str_replace('public/', '', $document->filepath)) }}" alt="After {{ $title }} {{ $followUp['day'] }} Image" style="max-width: 100px;">
                        @else
                            No image
                        @endif
                    </td>
                    <td>
                        <button 
                            class="btn btn-secondary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#updateModalFile" 
                            data-field-title="After {{ $title }} {{ $followUp['day'] }} Image"
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
