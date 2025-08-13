<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certyfikat - {{ $certificate->course->title }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 2cm;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .certificate-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .certificate-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        .header {
            margin-bottom: 40px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }
        .main-title {
            font-size: 36px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .course-title {
            font-size: 24px;
            color: #667eea;
            margin-bottom: 40px;
            font-weight: 600;
        }
        .certificate-text {
            font-size: 18px;
            color: #555;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        .user-name {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        .user-type {
            font-size: 16px;
            color: #666;
            margin-bottom: 40px;
        }
        .details {
            display: flex;
            justify-content: space-between;
            margin: 40px 0;
            flex-wrap: wrap;
        }
        .detail-item {
            flex: 1;
            min-width: 200px;
            margin: 10px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            text-align: center;
        }
        .detail-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        .detail-value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature {
            text-align: center;
            flex: 1;
        }
        .signature-line {
            width: 200px;
            height: 2px;
            background: #333;
            margin: 10px auto;
        }
        .certificate-number {
            font-size: 14px;
            color: #666;
            margin-top: 20px;
        }
        .validity {
            font-size: 12px;
            color: #999;
            margin-top: 10px;
        }
        .stamp {
            position: absolute;
            top: 50px;
            right: 50px;
            width: 100px;
            height: 100px;
            border: 3px solid #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #667eea;
            font-weight: bold;
            transform: rotate(15deg);
        }
        @media print {
            body {
                background: white;
            }
            .certificate-container {
                box-shadow: none;
                border: 2px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="stamp">CERTYFIKAT</div>
        
        <div class="header">
            @if($certificate->course->certificate_header)
                {!! nl2br(e($certificate->course->certificate_header)) !!}
            @else
                <div class="logo">Platforma Szkoleń Farmaceutycznych</div>
                <div class="subtitle">Profesjonalne szkolenia online dla branży farmaceutycznej</div>
            @endif
        </div>

        <div class="main-title">CERTYFIKAT UKOŃCZENIA</div>
        <div class="course-title">{{ $certificate->course->title }}</div>

        <div class="certificate-text">
            Niniejszym zaświadcza się, że
        </div>

        <div class="user-name">{{ $user->name }}</div>

        <div class="certificate-text">
            pomyślnie ukończył(a) szkolenie online i uzyskał(a) wymagane kompetencje w zakresie przedstawionym w programie kursu.
        </div>

        <div class="details">
            <div class="detail-item">
                <div class="detail-label">Data ukończenia</div>
                <div class="detail-value">{{ $certificate->issued_at->format('d.m.Y') }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Poziom trudności</div>
                <div class="detail-value">{{ ucfirst($certificate->course->difficulty) }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Liczba lekcji</div>
                <div class="detail-value">{{ $certificate->course->lessons->count() }}</div>
            </div>
            @if($certificate->course->duration_hours)
                <div class="detail-item">
                    <div class="detail-label">Czas trwania</div>
                    <div class="detail-value">{{ $certificate->course->duration_hours }}h</div>
                </div>
            @endif
        </div>

        <div class="footer">
            @if($certificate->course->certificate_footer)
                <div style="width: 100%; text-align: center; font-size: 14px; color: #666;">
                    {!! nl2br(e($certificate->course->certificate_footer)) !!}
                </div>
            @else
                <div class="signature">
                    <div class="signature-line"></div>
                    <div>Podpis wydawcy</div>
                </div>
                <div class="signature">
                    <div class="signature-line"></div>
                    <div>Data wydania</div>
                </div>
            @endif
        </div>

        <div class="certificate-number">
            Numer certyfikatu: {{ $certificate->certificate_number }}
        </div>

        @if($certificate->expires_at)
            <div class="validity">
                Certyfikat ważny do: {{ $certificate->expires_at->format('d.m.Y') }}
            </div>
        @endif
    </div>
</body>
</html>
