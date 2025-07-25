<!DOCTYPE html>
<html>
<head>
    <title>Status Permintaan Data Diperbarui</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #2563eb; color: white; padding: 10px; text-align: center; }
        .content { padding: 20px; background-color: #f9f9f9; }
        .footer { margin-top: 20px; font-size: 12px; text-align: center; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>PUSDATIN UNIGA</h2>
        </div>
        
        <div class="content">
            <p>Halo {{ $dataRequest->requester_name }},</p>
            
            <p>Status permintaan Data Anda telah diperbarui:</p>
            
            <ul>
                <li><strong>ID Permintaan:</strong> {{ $dataRequest->id }}</li>
                <li><strong>Judul:</strong> {{ $dataRequest->title }}</li>
                <li><strong>Status Baru:</strong> {{ ucfirst($status) }}</li>
                <li><strong>Tanggal Diperbarui:</strong> {{ now()->format('d M Y H:i') }}</li>
            </ul>
            
            <p>Terima kasih,</p>
            <p>Tim PUSDATIN UNIGA</p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} PUSDATIN Universitas Garut. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</body>
</html>