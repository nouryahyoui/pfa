@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="page-title">
            <i class="bi bi-chat-dots"></i> Mes messages
        </h2>
    </div>
</div>

@if($messages->count() > 0)
    @foreach($messages as $annonce_id => $conversation)
    @php $dernierMessage = $conversation->last(); @endphp
    <div class="card mb-3 shadow-sm" data-aos="fade-up">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-megaphone"></i>
                        {{ $dernierMessage->annonce->titre }}
                    </h5>
                    <p class="text-muted mb-1">
                        <i class="bi bi-person"></i>
                        @if($dernierMessage->sender_id === auth()->id())
                            À : {{ $dernierMessage->receiver->name }}
                        @else
                            De : {{ $dernierMessage->sender->name }}
                        @endif
                    </p>
                    <p class="mb-0 text-truncate" style="max-width:400px;">
                        {{ $dernierMessage->contenu }}
                    </p>
                </div>
                <div class="text-end">
                    <p class="text-muted small mb-2">
                        {{ $dernierMessage->created_at->format('d/m/Y H:i') }}
                    </p>
                    <a href="{{ route('messages.conversation', $dernierMessage->annonce) }}"
                        class="btn btn-sm text-white"
                        style="background:linear-gradient(135deg,#1a1a2e,#0f3460); border-radius:10px;">
                        <i class="bi bi-chat"></i> Voir la conversation
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@else
    <div class="text-center py-5">
        <i class="bi bi-chat-dots display-1 text-muted"></i>
        <h4 class="text-muted mt-3">Aucun message</h4>
    </div>
@endif
@endsection