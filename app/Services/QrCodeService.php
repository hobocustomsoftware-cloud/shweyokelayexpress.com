<?php
namespace App\Services;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class QrCodeService
{
    public function saveQrcode($cargo_data)
    {
        if(!$cargo_data){
            return null;
        }
        try{
            $qrCode = QrCode::format('png')
            ->size(400)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($cargo_data);
            // $image = Image::make($qrCode)
            //      ->resize(400, 400);
            $path = 'images/qrcodes/' . uniqid() . '.png';
            Storage::disk('public_folder')->put($path, $qrCode);
            return $path;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
