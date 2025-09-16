<x-guest-layout>
    <div class="form-title">Resetowanie hasła</div>

    <div class="form-description">
        Wprowadź swój adres e-mail i nowe hasło, aby dokończyć proces resetowania.
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="input-group">
            <label for="email" class="input-label">Adres e-mail</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" />
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-group">
            <label for="password" class="input-label">Nowe hasło</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="input-group">
            <label for="password_confirmation" class="input-label">Potwierdź nowe hasło</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" />
            @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-primary">
            Zresetuj hasło
        </button>
    </form>
</x-guest-layout>
