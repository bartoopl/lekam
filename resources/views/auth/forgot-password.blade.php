<x-guest-layout>
    <div class="form-title">Przypomnienie hasła</div>

    <div class="form-description">
        Nie pamiętasz hasła? Nic nie szkodzi. Podaj swój adres e-mail, a wyślemy Ci link do zresetowania hasła, który pozwoli Ci wybrać nowe.
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="success-message">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <label for="email" class="input-label">Adres e-mail</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus />
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-primary">
            Wyślij link resetowania hasła
        </button>
    </form>
</x-guest-layout>
