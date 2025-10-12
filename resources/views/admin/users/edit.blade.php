@extends('layouts.app')

@section('content')
<style>
    html, body {
        background-image: url('/images/backgrounds/bg.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    .admin-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
    }

    .admin-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .admin-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #21235F;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .back-button {
        background: linear-gradient(135deg, #6B7280 0%, #4B5563 100%);
        color: white !important;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
    }

    .back-button:hover {
        background: linear-gradient(135deg, #4B5563 0%, #374151 100%);
        transform: translateY(-2px);
        color: white !important;
        text-decoration: none;
        box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4);
    }

    .form-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #E5E7EB;
        border-radius: 12px;
        background: white;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #21235F;
        box-shadow: 0 0 0 3px rgba(33, 35, 95, 0.1);
    }

    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #E5E7EB;
        border-radius: 12px;
        background: white;
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        outline: none;
        border-color: #21235F;
        box-shadow: 0 0 0 3px rgba(33, 35, 95, 0.1);
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: #F9FAFB;
        border-radius: 10px;
        border: 2px solid #E5E7EB;
        transition: all 0.3s ease;
    }

    .checkbox-container:hover {
        border-color: #21235F;
        background: #F3F4F6;
    }

    .admin-checkbox {
        width: 20px;
        height: 20px;
        accent-color: #21235F;
        cursor: pointer;
    }

    .checkbox-label {
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        color: #374151;
        cursor: pointer;
        margin: 0;
    }

    .checkbox-description {
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        color: #6B7280;
        margin-top: 0.25rem;
    }

    .btn-container {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #21235F 0%, #3B82F6 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(33, 35, 95, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1a1a4d 0%, #2563EB 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(33, 35, 95, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: #6B7280;
        color: white;
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
    }

    .btn-secondary:hover {
        background: #4B5563;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(107, 114, 128, 0.4);
        color: white;
        text-decoration: none;
    }

    .error-message {
        color: #EF4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .warning-box {
        background: #FEF3C7;
        border: 2px solid #F59E0B;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .warning-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: #92400E;
        margin-bottom: 0.5rem;
    }

    .warning-text {
        font-family: 'Poppins', sans-serif;
        color: #92400E;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 1rem;
        }

        .admin-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .btn-container {
            flex-direction: column;
        }
    }
</style>

<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1 class="admin-title">Edycja Użytkownika</h1>
        <a href="{{ route('admin.users') }}" class="back-button">
            ← Powrót do listy
        </a>
    </div>

    <!-- Form -->
    <div class="form-container">
        @if($user->id === auth()->id())
            <div class="warning-box">
                <div class="warning-title">⚠️ Uwaga!</div>
                <div class="warning-text">
                    Edytujesz swoje własne konto. Nie możesz usunąć sobie uprawnień administratora.
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Imię i nazwisko</label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       class="form-input"
                       required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Adres e-mail</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       class="form-input"
                       required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- User Type -->
            <div class="form-group">
                <label for="user_type" class="form-label">Typ użytkownika</label>
                <select id="user_type" name="user_type" class="form-select" required>
                    <option value="farmaceuta" {{ old('user_type', $user->user_type) === 'farmaceuta' ? 'selected' : '' }}>
                        Farmaceuta
                    </option>
                    <option value="technik_farmacji" {{ old('user_type', $user->user_type) === 'technik_farmacji' ? 'selected' : '' }}>
                        Technik farmacji
                    </option>
                </select>
                @error('user_type')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Representative -->
            <div class="form-group">
                <label for="representative_id" class="form-label">Przedstawiciel</label>
                <select id="representative_id" name="representative_id" class="form-select">
                    <option value="">-- Brak przypisania --</option>
                    @foreach($representatives as $representative)
                        <option value="{{ $representative->id }}"
                                {{ old('representative_id', $user->representative_id) == $representative->id ? 'selected' : '' }}>
                            {{ $representative->name }} ({{ $representative->email }})
                        </option>
                    @endforeach
                </select>
                <div class="checkbox-description" style="margin-top: 0.5rem;">
                    Przypisz użytkownika do przedstawiciela handlowego
                </div>
                @error('representative_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Admin Privileges -->
            <div class="form-group">
                <label class="form-label">Uprawnienia administratora</label>
                <div class="checkbox-container">
                    <input type="checkbox"
                           id="is_admin"
                           name="is_admin"
                           value="1"
                           class="admin-checkbox"
                           {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}
                           {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    <div>
                        <label for="is_admin" class="checkbox-label">
                            Nadaj uprawnienia administratora
                        </label>
                        <div class="checkbox-description">
                            Administrator ma dostęp do panelu zarządzania systemem
                        </div>
                    </div>
                </div>
                @error('is_admin')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- User Stats -->
            <div class="form-group">
                <label class="form-label">Statystyki użytkownika</label>
                <div style="background: #F9FAFB; padding: 1rem; border-radius: 10px; font-family: 'Poppins', sans-serif;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <div>
                            <div style="font-weight: 600; color: #374151;">Zarejestrowany:</div>
                            <div style="color: #6B7280;">{{ $user->created_at->format('d.m.Y H:i') }}</div>
                        </div>
                        <div>
                            <div style="font-weight: 600; color: #374151;">Certyfikaty:</div>
                            <div style="color: #6B7280;">{{ $user->certificates->count() }}</div>
                        </div>
                        <div>
                            <div style="font-weight: 600; color: #374151;">Ostatnia aktywność:</div>
                            <div style="color: #6B7280;">{{ $user->updated_at->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="btn-container">
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                    Anuluj
                </a>
                <button type="submit" class="btn btn-primary">
                    Zapisz zmiany
                </button>
            </div>
        </form>
    </div>
</div>
@endsection