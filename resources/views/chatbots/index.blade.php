@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        <h1>Daftar Chatbot WhatsApp</h1>
        
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

        <a href="{{ route('chatbots.create') }}" class="btn btn-primary mb-3">Tambah Chatbot</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Status Aktif</th>
                    <th>QR Code</th>
                    <th>Nomor WhatsApp</th> 
                    <th>Nomor Whatsapp Tersambung</th>
                    <th>Status Koneksi</th> 
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chatbots as $chatbot)
                    <tr id="chatbot-{{ $chatbot->id }}">
                        <td>
                            @if ($chatbot->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if ($chatbot->qrcode)
                                <button onclick="showQr('{{ $chatbot->id }}')" class="btn btn-sm btn-secondary">Tampilkan QR Code</button>
                            @else
                                <span class="text-muted">Tidak tersedia</span>
                            @endif
                        </td>
                        <td>{{ $chatbot->whatsapp_number ?? 'Tidak tersedia' }}</td>
                        <td>{{ $chatbot->whatsapp_number_linked ?? 'Tidak tersedia' }}</td>
                        <td>
                            @if ($chatbot->is_connect)
                                <span class="badge bg-success">Terkoneksi</span>
                            @else
                                <span class="badge bg-danger">Tidak Terkoneksi</span>
                            @endif
                        </td> 
                        <td>
                            <a href="{{ route('chatbots.edit', $chatbot->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">QR Code : <span id="whatsappNumber"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div style="margin: 10px;">Jika Popup ini tidak hilang atau Nomor Whatsapp Tersambung masih tidak tersedia saat status perangkat sudah tertaut, itu berarti nomor whatsapp yang anda tautkan tidak sesuai.</div>
                <div class="modal-body mx-auto text-center" style="align-items: center;" id="qrCodeContainer">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        let intervalId;
        let currentChatbotId;
        let dataChatbot = [];

        function showQr(id) {
            currentChatbotId = id;
            updateQrCode();
            const qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
            qrModal.show();

            intervalId = setInterval(updateQrCode, 2000);
        }

        function updateQrCode() {
            if (currentChatbotId) {
                for (const chatbot of dataChatbot) {
                    if (chatbot.id == currentChatbotId) {
                        const qrCodeContainer = document.getElementById('qrCodeContainer');
                        const whatsappNumberContainer = document.getElementById('whatsappNumber');
                        qrCodeContainer.innerHTML = "";
                        whatsappNumberContainer.innerHTML = chatbot.whatsapp_number;
                        if (chatbot.qrcode) {
                            new QRCode(qrCodeContainer, {
                                text: chatbot.qrcode,
                                width: 300,
                                height: 300,
                            });
                        } else {
                            qrCodeContainer.innerHTML = `<p class="text-muted">QR Code belum tersedia.</p>`;
                        }

                        if (chatbot.is_connect) {
                            const qrModal = bootstrap.Modal.getInstance(document.getElementById('qrModal'));
                            qrModal.hide();
                            clearInterval(intervalId);
                            currentChatbotId = null;
                        }

                        break; 
                    }
                }
            }
        }

        function updateAllChatbotData() {
            fetch(`/chatbots/check-all-status`)
                .then(response => response.json())
                .then(data => {
                    dataChatbot = data.map(obj => Object.assign({}, obj));

                    data.forEach(chatbot => {
                        const row = document.getElementById(`chatbot-${chatbot.id}`);
                        if (chatbot.qrcode) {
                            row.querySelector('td:nth-child(2)').innerHTML = `<button onclick="showQr('${chatbot.id}')" class="btn btn-sm btn-secondary">Tampilkan QR Code</button>`;
                        } else {
                            row.querySelector('td:nth-child(2)').innerHTML = `<span class="text-muted">Tidak tersedia</span>`;
                        }

                        if (chatbot.whatsapp_number) {
                            row.querySelector('td:nth-child(3)').innerHTML = `<span>${chatbot.whatsapp_number}</span>`;
                        } else {
                            row.querySelector('td:nth-child(3)').innerHTML = `<span class="text-muted">Tidak tersedia</span>`;
                        }

                        if (chatbot.whatsapp_number_linked) {
                            row.querySelector('td:nth-child(4)').innerHTML = `<span>${chatbot.whatsapp_number_linked}</span>`;
                        } else {
                            row.querySelector('td:nth-child(4)').innerHTML = `<span class="text-muted">Tidak tersedia</span>`;
                        }

                        row.querySelector('td:nth-child(5)').innerHTML = chatbot.is_connect
                            ? '<span class="badge bg-success">Terkoneksi</span>'
                            : '<span class="badge bg-danger">Tidak Terkoneksi</span>';
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        setInterval(updateAllChatbotData, 2000);
    </script>
@endsection
