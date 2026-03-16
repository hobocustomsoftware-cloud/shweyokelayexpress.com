<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Voucher - {{ $cargo->voucher_number }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Myanmar:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        @page {
            size: 80mm auto;
            margin: 0;
            padding: 0;
        }
        
        body {
            width: 80mm;
            margin: 0;
            padding: 2mm;
            font-size: 10px;
            line-height: 1.2;
            font-family: 'Noto Sans Myanmar', sans-serif;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .print-area {
            width: 100%;
            max-width: 80mm;
            margin: 0 auto;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-bold {
            font-weight: bold;
        }
        
        .text-uppercase {
            text-transform: uppercase;
        }
        
        .border-bottom {
            border-bottom: 1px dashed #000;
        }
        
        .py-1 {
            padding-top: 2mm;
            padding-bottom: 2mm;
        }
        
        .my-1 {
            margin-top: 2mm;
            margin-bottom: 2mm;
        }
        
        .d-flex {
            display: flex;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .w-50 {
            width: 50%;
        }
        
        .w-100 {
            width: 100%;
        }
        
        .qr-code {
            max-width: 40mm;
            height: auto;
            margin: 2mm auto;
            display: block;
        }
        
        .cargo-image {
            max-width: 70mm;
            max-height: 40mm;
            object-fit: contain;
            display: block;
            margin: 2mm auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 2mm;
        }
        
        .section {
            margin: 2mm 0;
            padding: 1mm 0;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 2mm 0;
        }
        
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -1mm;
        }
        
        .col-6 {
            width: 50%;
            padding: 0 1mm;
            box-sizing: border-box;
        }
        
        .text-right {
            text-align: right;
        }
        
        @media print {
            body {
                padding: 1mm;
            }
            
            .no-print {
                display: none !important;
            }
        }
        
        @page {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="print-area">
        <div class="header">
            <div class="text-bold text-uppercase" style="font-size: 12px;">Shwe Yoke Lay Cargo</div>
            <div>Voucher No: {{ $cargo->voucher_number }}</div>
            <div>Date: {{ date('d/m/Y H:i', strtotime($cargo->created_at)) }}</div>
        </div>
        
        <div class="divider"></div>
        
        <div class="section">
            <div class="text-bold border-bottom py-1">Sender (ပို့သူ)</div>
            <div>{{ $cargo->sender_merchant->name ?? $cargo->s_name_string }}</div>
            <div>Ph: {{ $cargo->s_phone }}</div>
            <div>From: {{ $cargo->fromCity->name_my }} - {{ $cargo->fromGate->name_my }}</div>
        </div>
        
        <div class="divider"></div>
        
        <div class="section">
            <div class="text-bold border-bottom py-1">Receiver (လက်ခံသူ)</div>
            <div>{{ $cargo->receiver_merchant->name ?? $cargo->r_name_string }}</div>
            <div>Ph: {{ $cargo->r_phone }}</div>
            <div>To: {{ $cargo->toCity->name_my }} - {{ $cargo->toGate->name_my }}</div>
        </div>
        
        <div class="divider"></div>
        
        <div class="section">
            <div class="text-bold border-bottom py-1">Cargo Details (ကုန်ပစ္စည်းအချက်လက်)</div>
            <div class="row">
                <div class="col-6">Item No: {{ $cargo->cargo_no }}</div>
                <div class="col-6 text-right">Qty: {{ $cargo->quantity }}</div>
            </div>
            <div>Type: {{ $cargo->cargoType->name }}</div>
            <div>Delivery: {{ $delivery_type }}</div>
            @if(isset($cargo_image) && $cargo_image)
            <img src="{{ public_asset($cargo_image) }}" alt="Cargo" class="cargo-image">
            @endif
        </div>
        
        <div class="divider"></div>
        
        <div class="section">
            <div class="text-bold border-bottom py-1">Payment (ငွေကြေးအချက်လက်)</div>
            <div class="d-flex justify-between">
                <span>Service Charge:</span>
                <span>{{ $service_charge }} Ks</span>
            </div>
            <div class="d-flex justify-between">
                <span>Short Delivery:</span>
                <span>{{ $short_deli_fee }} Ks</span>
            </div>
            @if($cargo->delivery_type === 'home')
            <div class="d-flex justify-between">
                <span>Delivery Fee:</span>
                <span>{{ $final_deli_fee }} Ks</span>
            </div>
            @endif
            <div class="d-flex justify-between">
                <span>Border Fee:</span>
                <span>{{ $border_fee }} Ks</span>
            </div>
            <div class="d-flex justify-between text-bold" style="border-top: 1px dashed #000; margin-top: 2mm; padding-top: 1mm;">
                <span>Total:</span>
                <span>{{ $total_fee }} Ks</span>
            </div>
            @if($cargo->is_debt)
            <div class="text-bold text-center" style="margin-top: 2mm; color: red;">*** ကြွေးကုန်ပစ္စည်း ***</div>
            @endif
        </div>
        
        <div class="divider"></div>
        
        <div class="section text-center">
            <div>Status: {{ $cargo_status }}</div>
            <div>Entry: {{ $entry_date ?? 'N/A' }}</div>
            <div>Pickup Before: {{ $to_take_date ?? 'N/A' }}</div>
            <div>Counter: {{ $cargo->fromGate->name_my }}</div>
            <div>Staff: {{ $user->name }}</div>
            @if(isset($qrcode_image) && $qrcode_image)
            <img src="{{ public_asset($qrcode_image) }}" alt="QR Code" class="qr-code">
            @endif
            <div style="margin-top: 2mm;">Thank you for choosing us!</div>
        </div>
    </div>

    <script>
        // Auto-print when the page loads
        window.onload = function() {
            // Small delay to ensure all content is loaded
            setTimeout(function() {
                window.print();
                // Close the window after printing (optional)
                // setTimeout(function() { window.close(); }, 1000);
            }, 500);
        }
        
        // Also allow manual printing with a button
        document.addEventListener('keydown', function(e) {
            // Ctrl+P or Cmd+P
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });
    </script>
</body>
</html>
