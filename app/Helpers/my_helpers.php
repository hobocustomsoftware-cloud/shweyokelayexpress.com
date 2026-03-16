<?php
use Illuminate\Support\Facades\DB;

if (!function_exists('changeCargoStatusMM')) {
    function changeCargoStatusMM($status)
    {
        // 
    }
}

if (!function_exists('generateCargoNumber')) {
    function generateCargoNumber()
    {
        $date = now()->format('Y');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return "{$date}-{$random}";
    }
}

if (!function_exists('generateVoucherNumber')) {
    function generateVoucherNumber()
    {
        return \Illuminate\Support\Facades\DB::transaction(function () {
            $latestVoucher = DB::table('cargos')
                ->lockForUpdate()
                ->orderBy('voucher_number', 'desc')
                ->value('voucher_number');

            $lastNumber = $latestVoucher ? (int) $latestVoucher : 10000;
            return str_pad((string) ($lastNumber + 1), 5, '0', STR_PAD_LEFT);
        });
    }
}
if (!function_exists('generateTransitCargoNumber')) {
    function generateTransitCargoNumber()
    {
        $date = now()->format('Y');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        return "{$date}-{$random}";
    }
}

if (!function_exists('generateTransitCargoVoucherNumber')) {
    function generateTransitCargoVoucherNumber()
    {
        return \Illuminate\Support\Facades\DB::transaction(function () {
            $latestVoucher = DB::table('transit_cargos')
                ->lockForUpdate()
                ->orderBy('voucher_number', 'desc')
                ->value('voucher_number');

            $lastNumber = $latestVoucher ? (int) $latestVoucher : 10000;
            return str_pad((string) ($lastNumber + 1), 5, '0', STR_PAD_LEFT);
        });
    }
}

if (!function_exists('generateTransitPassengerVoucherNumber')) {
    function generateTransitPassengerVoucherNumber()
    {
        return \Illuminate\Support\Facades\DB::transaction(function () {
            $latestVoucher = DB::table('transit_passengers')
                ->lockForUpdate()
                ->orderBy('voucher_number', 'desc')
                ->value('voucher_number');

            $lastNumber = $latestVoucher ? (int) $latestVoucher : 10000;
            return str_pad((string) ($lastNumber + 1), 5, '0', STR_PAD_LEFT);
        });
    }
}
