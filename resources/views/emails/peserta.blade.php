<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Code Presensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        .instructions {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>QR Code Presensi</h1>
            <p>Sistem Presensi Digital</p>
        </div>
        
        <div class="content">
            <h2>Halo, {{ $peserta->nama }}!</h2>
            
            <p>Berikut adalah QR Code personal Anda untuk sistem presensi:</p>
            
            <div class="qr-code">
                <p><strong>Simpan QR Code ini dengan baik!</strong></p>
                <img src="{{ $message->embed($qrCodePath) }}" alt="QR Code" style="max-width: 200px;">
                <p style="font-size: 12px; color: #666; margin-top: 10px;">
                    Kode Unik: {{ $peserta->qr_hash }}
                </p>
            </div>

            <div class="instructions">
                <h3>Cara Menggunakan:</h3>
                <ol>
                    <li><strong>Bawa QR Code</strong> ini (dalam bentuk digital)</li>
                    <li><strong>Tunjukkan QR Code</strong> ke scanner saat presensi</li>
                    <li><strong>Pastikan QR Code</strong> terlihat jelas dan tidak rusak</li>
                    <li><strong>QR Code ini bersifat personal</strong>, jangan bagikan ke orang lain</li>
                </ol>
            </div>

            <div style="background: #e7f3ff; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <h4 style="margin-top: 0; color: #0066cc;">📋 Informasi Peserta:</h4>
                <p><strong>Nama:</strong> {{ $peserta->nama }}</p>
                <p><strong>Email:</strong> {{ $peserta->email }}</p>
                <p><strong>No. Identitas:</strong> {{ $peserta->nomor_peserta ?? '-' }}</p>
                <p><strong>Kode Unik:</strong> {{ $peserta->qr_hash }}</p>
            </div>

            <p>Jika Anda mengalami kendala atau kehilangan QR Code, segera hubungi administrator.</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Sistem Presensi QR Code. All rights reserved.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas.</p>
        </div>
    </div>
</body>
</html>