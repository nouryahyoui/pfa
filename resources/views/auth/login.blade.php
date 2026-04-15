@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm" style="border-radius:15px; border:none;">
            <div class="card-body p-5">
                <h3 class="text-center fw-bold mb-4" style="color:#1a1a2e;">
                    <i class="bi bi-box-arrow-in-right"></i> Connexion
                </h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="votre@email.com"
                            style="border-radius:10px; padding:12px;">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mot de passe</label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            style="border-radius:10px; padding:12px;">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn text-white btn-lg"
                            style="background:linear-gradient(135deg,#1a1a2e,#0f3460); border-radius:10px;">
                            <i class="bi bi-box-arrow-in-right"></i> Se connecter
                        </button>
                    </div>
                </form>
                <hr>
                <p class="text-center mb-0">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" style="color:#e94560;">S'inscrire</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection