@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-sm mb-3" style="border-radius:15px;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-megaphone"></i> {{ $annonce->titre }}
                    </h5>
                    <small class="text-muted">
                        <i class="bi bi-person"></i> {{ $annonce->user->name }}
                    </small>
                </div>
                <a href="{{ route('annonces.show', $annonce) }}"
                    class="btn btn-sm btn-outline-dark" style="border-radius:10px;">
                    <i class="bi bi-eye"></i> Voir l'annonce
                </a>
            </div>
        </div>

        <div class="card shadow-sm mb-3" style="border-radius:15px; min-height:400px;">
            <div class="card-body p-4" style="max-height:500px; overflow-y:auto;" id="messagesBox">
                @forelse($messages as $message)
                    @if($message->sender_id === auth()->id())
                        <div class="d-flex justify-content-end mb-3">
                            <div class="p-3 text-white"
                                style="background:linear-gradient(135deg,#1a1a2e,#0f3460);border-radius:15px 15px 0 15px;max-width:70%;">
                                <p class="mb-1">{{ $message->contenu }}</p>
                                <small style="opacity:0.7;">{{ $message->created_at->format('H:i') }}</small>
                            </div>
                        </div>
                    @else
                        <div class="d-flex justify-content-start mb-3">
                            <div class="p-3"
                                style="background:#f0f0f0;border-radius:15px 15px 15px 0;max-width:70%;">
                                <small class="fw-bold text-muted d-block mb-1">{{ $message->sender->name }}</small>
                                <p class="mb-1">{{ $message->contenu }}</p>
                                <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-chat display-3"></i>
                        <p class="mt-3">Commencez la conversation !</p>
                    </div>
                @endforelse
            </div>
        </div>

        @auth
        <div class="card shadow-sm" style="border-radius:15px;">
            <div class="card-body">
                <form method="POST" action="{{ route('messages.store', $annonce) }}">
                    @csrf
                    <div class="d-flex gap-2">
                        <input type="text" name="contenu"
                            class="form-control @error('contenu') is-invalid @enderror"
                            placeholder="Écrire un message..."
                            style="border-radius:10px;"
                            autocomplete="off">
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn text-white px-4"
                            style="background:linear-gradient(135deg,#e94560,#c73652);border-radius:10px;">
                            <i class="bi bi-send"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endauth

        <div class="mt-3">
            <a href="{{ route('messages.index') }}" class="btn btn-secondary" style="border-radius:10px;">
                <i class="bi bi-arrow-left"></i> Retour aux messages
            </a>
        </div>

    </div>
</div>

<script>
    const box = document.getElementById('messagesBox');
    if(box) box.scrollTop = box.scrollHeight;
</script>
@endsection