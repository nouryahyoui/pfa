@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="page-title">
            <i class="bi bi-bell"></i> Mes notifications
        </h2>
    </div>
</div>

@if($notifications->count() > 0)
    @foreach($notifications as $notification)
    <div class="card mb-3 shadow-sm {{ $notification->lu ? '' : 'border-start border-4 border-primary' }}"
        style="border-radius:15px;" data-aos="fade-up">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white"
                    style="width:45px; height:45px; background:linear-gradient(135deg,#1a1a2e,#0f3460); flex-shrink:0;">
                    @if(str_contains($notification->message, 'approuvée'))
                        <i class="bi bi-check-circle"></i>
                    @elseif(str_contains($notification->message, 'rejetée'))
                        <i class="bi bi-x-circle"></i>
                    @else
                        <i class="bi bi-bell"></i>
                    @endif
                </div>
                <div>
                    <p class="mb-1 {{ $notification->lu ? 'text-muted' : 'fw-bold' }}">
                        {{ $notification->message }}
                    </p>
                    <small class="text-muted">
                        <i class="bi bi-clock"></i>
                        {{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
            @if(!$notification->lu)
                <span class="badge bg-primary rounded-pill">Nouveau</span>
            @endif
        </div>
    </div>
    @endforeach
@else
    <div class="text-center py-5" data-aos="fade-up">
        <i class="bi bi-bell display-1 text-muted"></i>
        <h4 class="text-muted mt-3">Aucune notification</h4>
    </div>
@endif
@endsection