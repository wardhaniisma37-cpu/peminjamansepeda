<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Peminjaman - E-Bike</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
            background: #f0f0f0;
        }
        .struk {
            max-width: 320px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .struk-inner {
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 10px;
            color: #666;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .divider {
            border-top: 1px dashed #ccc;
            margin: 10px 0;
        }
        .total {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 10px;
            color: #666;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-returned { background: #d1fae5; color: #065f46; }
        .status-borrowed { background: #fed7aa; color: #92400e; }
        .btn-print {
            display: block;
            width: 320px;
            margin: 20px auto;
            background: #3b82f6;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 40px;
            font-size: 14px;
            cursor: pointer;
            font-family: inherit;
        }
        .btn-print:hover { background: #2563eb; }
        @media print {
            body { background: white; padding: 0; }
            .btn-print { display: none; }
            .struk { box-shadow: none; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="struk">
        <div class="struk-inner">
            <div class="header">
                <h1> RENTAL SEPEDA LISTRIK 
                          YOGYAKARTA
                </h1>
                <p>Jl.SURIPTOPO NO.905,MANTRIJERON
                    KEC.MANTRIJERON,KOTA YOGYAKARTA
                </p>
                <p>Telp: +62 831-9066-2982</p>
            </div>

            <div class="row">
                <span>No. Transaksi:</span>
                <span><strong>#{{ $loan->id }}</strong></span>
            </div>
            <div class="row">
                <span>Tanggal:</span>
                <span>{{ \Carbon\Carbon::parse($loan->created_at)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="row">
                <span>Kasir:</span>
                <span>{{ Auth::user()->name ?? 'Admin' }}</span>
            </div>

            <div class="divider"></div>

            <div class="row">
                <span>Peminjam:</span>
                <span><strong>{{ $loan->user->name ?? '-' }}</strong></span>
            </div>
            <div class="row">
                <span>Barang:</span>
                <span>{{ $loan->item->name ?? '-' }}</span>
            </div>
            <div class="row">
                <span>Jumlah:</span>
                <span>{{ $loan->amount }} unit</span>
            </div>
            <div class="row">
                <span>Tgl Pinjam:</span>
                <span>{{ \Carbon\Carbon::parse($loan->borrow_date)->format('d/m/Y') }}</span>
            </div>
            @if($loan->return_date)
            <div class="row">
                <span>Tgl Kembali:</span>
                <span>{{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') }}</span>
            </div>
            @endif
            <div class="row">
                <span>Status:</span>
                <span>
                    @if($loan->status == 'returned')
                        <span class="status-badge status-returned"> Dikembalikan</span>
                    @else
                        <span class="status-badge status-borrowed">🕐 Dipinjam</span>
                    @endif
                </span>
            </div>

            @if($loan->condition_return)
            <div class="divider"></div>
            <div class="row">
                <span>Kondisi:</span>
                <span>
                    @if($loan->condition_return == 'baik') Baik
                    @elseif($loan->condition_return == 'rusak_ringan') Rusak Ringan
                    @elseif($loan->condition_return == 'rusak_berat') Rusak Berat
                    @else Hilang
                    @endif
                </span>
            </div>
            @endif

            @if($loan->penalty_amount > 0)
            <div class="row total">
                <span>Denda:</span>
                <span>Rp {{ number_format($loan->penalty_amount, 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>Metode Bayar:</span>
                <span>{{ $loan->payment_method == 'cash' ? 'Tunai' : 'Transfer' }}</span>
            </div>
            @endif

            <div class="footer">
                <p>Terima kasih telah menggunakan</p>
                <p>Layanan Rental Sepeda Listrik</p>
                
            </div>
        </div>
    </div>

    <button class="btn-print" onclick="window.print()">
        <i class="fas fa-print"></i> Cetak Struk
    </button>

    <script>
        // Auto print jika perlu (uncomment untuk auto print)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>