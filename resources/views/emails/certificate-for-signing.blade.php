<p>Dzień dobry,</p>

<p>W załączeniu przesyłam certyfikat do podpisu kwalifikowanego dla użytkownika:</p>

<ul>
    <li><strong>Imię i nazwisko:</strong> {{ $user->name }}</li>
    <li><strong>E-mail użytkownika:</strong> {{ $user->email }}</li>
    <li><strong>Typ użytkownika:</strong> {{ $user->isTechnician() ? 'Technik farmacji' : 'Farmaceuta' }}</li>
    <li><strong>Kurs:</strong> {{ $course->title }}</li>
    <li><strong>Numer certyfikatu:</strong> {{ $certificate->certificate_number }}</li>
    <li><strong>Data wystawienia:</strong> {{ optional($certificate->issued_at)->format('d.m.Y H:i') }}</li>
    @if($certificate->expires_at)
        <li><strong>Ważny do:</strong> {{ $certificate->expires_at->format('d.m.Y') }}</li>
    @endif
    @if($user->pharmacy_address)
        <li><strong>Apteka:</strong> {{ $user->pharmacy_address }}, {{ $user->pharmacy_postal_code }} {{ $user->pharmacy_city }}</li>
    @endif
    @if($user->pwz_number)
        <li><strong>Numer PWZ:</strong> {{ $user->pwz_number }}</li>
    @endif
    @if($user->license_number)
        <li><strong>Numer prawa wykonywania zawodu:</strong> {{ $user->license_number }}</li>
    @endif
</ul>

<p>Po podpisaniu prosimy o wysłanie podpisanego dokumentu do uczestnika na adres e-mail: <strong>{{ $user->email }}</strong>.</p>

<p>Pozdrawiamy,<br>Zespół Akademia Lek-Am</p>


