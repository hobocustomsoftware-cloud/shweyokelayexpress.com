@extends('admin.layouts.app')
@section('title', 'ကားတင်ရန် ကုန်ပစ္စည်း အသေးစိတ် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ကားတင်ရန် ကုန်ပစ္စည်း အသေးစိတ်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.putin_cargos.index') }}">ကားတင်ရန် ကုန်ပစ္စည်းများ</a></li>
                    <li class="breadcrumb-item active">ကားတင်ရန် ကုန်ပစ္စည်း အသေးစိတ်</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ကုန်ပစ္စည်းအကြောင်း အသေးစိတ်</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3">ပို့သူအချက်အလက်</h6>
                            <dl class="row">
                                <dt class="col-sm-4">အမည်</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->sender_merchant?->name ?? $car_cargo->cargo->s_name_string ?? 'N/A' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">ဖုန်းနံပါတ်</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->s_phone ?? 'N/A' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">မှတ်ပုံတင်အမှတ်</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->s_nrc ?? 'N/A' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">လိပ်စာ</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->s_address ?? 'N/A' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">မှ မြို့နှင့်ဂိတ်</dt>
                                <dd class="col-sm-8">
                                    {{ $car_cargo->cargo->fromCity?->name_my ?? 'N/A' }} - {{ $car_cargo->cargo->fromGate?->name_my ?? 'N/A' }}
                                </dd>
                            </dl>

                            <h6 class="mb-3 mt-4">လက်ခံသူအချက်အလက်</h6>
                            <dl class="row">
                                <dt class="col-sm-4">အမည်</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->receiver_merchant?->name ?? $car_cargo->cargo->r_name_string ?? 'N/A' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">ဖုန်းနံပါတ်</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->r_phone ?? 'N/A' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">မှတ်ပုံတင်အမှတ်</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->r_nrc ?? 'N/A' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">လိပ်စာ</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->r_address ?? 'N/A' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">သို့ မြို့နှင့်ဂိတ်</dt>
                                <dd class="col-sm-8">
                                    {{ $car_cargo->cargo->toCity?->name_my ?? 'N/A' }} - {{ $car_cargo->cargo->toGate?->name_my ?? 'N/A' }}
                                </dd>
                            </dl>
                        </div>

                        <div class="col-md-6">
                            <h6 class="mb-3">ကုန်ပစ္စည်းအချက်အလက်</h6>
                            <div class="image-container mb-3">
                                @if(isset($cargo_image) && $cargo_image)
                                    <img src="{{ public_asset($cargo_image) }}" alt="cargo image" class="img-thumbnail" style="max-height: 200px;">
                                @endif
                            </div>
                            <dl class="row">
                                <dt class="col-sm-4">ကုန်ပစ္စည်းအမှတ်</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->cargo_no }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">ဘောက်ချာနံပါတ်</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->voucher_number }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">ပို့ဆောင်မှုအမျိုးအစား</dt>
                                <dd class="col-sm-8">{{ strtoupper($car_cargo->cargo->delivery_type ?? 'N/A') }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">ကုန်ပစ္စည်းအမျိုးအစား</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->cargoType?->name ?? 'Standard' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">ကုန်ပစ္စည်းအသေးစိတ်</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->cargo_detail_name ?? 'N/A' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">အရေအတွက်</dt>
                                <dd class="col-sm-8">{{ $car_cargo->cargo->quantity }}</dd>
                            </dl>
                        </div>
                    </div>

                    <hr>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="mb-3">ငွေကြေးအချက်လက်များ</h6>
                            <table class="table table-sm table-bordered">
                                <tr><td>တန်ဆာခ</td><td class="text-end">{{ number_format((float)$service_charge) }} ကျပ်</td></tr>
                                <tr><td>တစ်ဆင့်သွားတန်ဆာခ</td><td class="text-end">{{ number_format((float)$transit_fee) }} ကျပ်</td></tr>
                                <tr><td>ခေါက်တိုကြေး</td><td class="text-end">{{ number_format((float)$short_deli_fee) }} ကျပ်</td></tr>
                                @if(isset($car_cargo->cargo->delivery_type) && $car_cargo->cargo->delivery_type === 'home')
                                <tr><td>အရောက်ပို့ကြေး</td><td class="text-end">{{ number_format((float)$final_deli_fee) }} ကျပ်</td></tr>
                                @endif
                                <tr><td>ဘော်ဒါကြေး</td><td class="text-end">{{ number_format((float)$border_fee) }} ကျပ်</td></tr>
                                <tr class="table-primary"><td><strong>စုစုပေါင်းကျသင့်ငွေ</strong></td><td class="text-end"><strong>{{ number_format((float)$total_fee) }} ကျပ်</strong></td></tr>
                            </table>
                            @if($car_cargo->cargo->is_debt)
                                <p class="text-danger">⚠️ ကုန်ကြွေးကုန်ပစ္စည်း</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <dl class="row">
                                <dt class="col-sm-4">ပစ္စည်းအခြေအနေ</dt>
                                <dd class="col-sm-8"><span class="badge bg-info">{{ $car_cargo->cargo_status }}</span></dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">ကုန်စာရင်းသွင်းရက်</dt>
                                <dd class="col-sm-8">{{ $entry_date ?? 'N/A' }}</dd>
                            </dl>
                            <dl class="row">
                                <dt class="col-sm-4">ကုန်ရွေးရမည့်ရက်</dt>
                                <dd class="col-sm-8">{{ $to_take_date ?? 'N/A' }}</dd>
                            </dl>
                            @if(isset($qrcode_image) && $qrcode_image)
                            <div class="mt-2">
                                <img src="{{ public_asset('uploads/' . $qrcode_image) }}" alt="qrcode" style="width: 100px;">
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        @livewire('car-choosing-form', ['cargo_id' => $car_cargo->cargo_id], key($car_cargo->id))
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-end">
                        <a href="{{ route('admin.putin_cargos.index') }}" class="btn btn-secondary">နောက်သို့</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection