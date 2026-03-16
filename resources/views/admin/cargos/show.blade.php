@extends('admin.layouts.app')
@section('title', 'ကုန်ပစ္စည်းအကြောင်း အသေးစိတ် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ကုန်ပစ္စည်းအကြောင်း အသေးစိတ်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.cargos.index') }}">ကုန်ပစ္စည်းများ</a></li>
                    <li class="breadcrumb-item active">ကုန်ပစ္စည်းအကြောင်း အသေးစိတ်</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="card-title text-primary">ကုန်ပစ္စည်းအကြောင်း အသေးစိတ်</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">ပို့သူအချက်အလက်</h6>
                                <dl class="row mb-4">
                                    <dt class="col-sm-4 text-muted">အမည်</dt>
                                    <dd class="col-sm-8 fw-bold">{{ $cargo->sender_merchant?->name ?? ($cargo->s_name_string ?: 'N/A') }}</dd>

                                    <dt class="col-sm-4 text-muted">ဖုန်းနံပါတ်</dt>
                                    <dd class="col-sm-8">{{ $cargo->s_phone ?: '09xxxxxxxxx' }}</dd>

                                    <dt class="col-sm-4 text-muted">မှတ်ပုံတင်အမှတ်</dt>
                                    <dd class="col-sm-8 text-muted">{{ $cargo->s_nrc ?: 'N/A' }}</dd>

                                    <dt class="col-sm-4 text-muted">လိပ်စာ</dt>
                                    <dd class="col-sm-8">{{ $cargo->s_address ?: ($cargo->fromCity?->name_my ?: 'N/A') }}</dd>

                                    <dt class="col-sm-4 text-muted">မှ မြို့နှင့်ဂိတ်</dt>
                                    <dd class="col-sm-8 text-primary">{{ $cargo->fromCity?->name_my }} - {{ $cargo->fromGate?->name_my }}</dd>
                                </dl>

                                <h6 class="fw-bold mb-3 border-bottom pb-2">လက်ခံသူအချက်အလက်</h6>
                                <dl class="row mb-4">
                                    <dt class="col-sm-4 text-muted">အမည်</dt>
                                    <dd class="col-sm-8 fw-bold">{{ $cargo->receiver_merchant?->name ?? ($cargo->r_name_string ?: 'N/A') }}</dd>

                                    <dt class="col-sm-4 text-muted">ဖုန်းနံပါတ်</dt>
                                    <dd class="col-sm-8">{{ $cargo->r_phone ?: '09xxxxxxxxx' }}</dd>

                                    <dt class="col-sm-4 text-muted">မှတ်ပုံတင်အမှတ်</dt>
                                    <dd class="col-sm-8 text-muted">{{ $cargo->r_nrc ?: 'N/A' }}</dd>

                                    <dt class="col-sm-4 text-muted">လိပ်စာ</dt>
                                    <dd class="col-sm-8">{{ $cargo->r_address ?: ($cargo->toCity?->name_my ?: 'N/A') }}</dd>

                                    <dt class="col-sm-4 text-muted">သို့ မြို့နှင့်ဂိတ်</dt>
                                    <dd class="col-sm-8 text-primary">{{ $cargo->toCity?->name_my }} - {{ $cargo->toGate?->name_my }}</dd>
                                </dl>

                                <h6 class="fw-bold mb-3 border-bottom pb-2">ငွေကြေးအချက်လက်များ</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-borderless">
                                        <tr><td width="40%">တန်ဆာခ</td><td class="text-end fw-bold">{{ number_format($cargo->service_charge, 2) }} ကျပ်</td></tr>
                                        <tr><td>တစ်ဆင့်သွားတန်ဆာခ</td><td class="text-end fw-bold">{{ number_format($cargo->transit_fee, 2) }} ကျပ်</td></tr>
                                        <tr><td>ခေါက်တိုကြေး</td><td class="text-end fw-bold">{{ number_format($cargo->short_deli_fee, 2) }} ကျပ်</td></tr>
                                        <tr><td>အရောက်ပို့ကြေး</td><td class="text-end fw-bold">{{ number_format($cargo->final_deli_fee, 2) }} ကျပ်</td></tr>
                                        <tr><td>ဘော်ဒါကြေး</td><td class="text-end fw-bold">{{ number_format($cargo->border_fee, 2) }} ကျပ်</td></tr>
                                        <tr class="border-top">
                                            <td class="fw-bold">စုစုပေါင်းကျသင့်ငွေ</td>
                                            <td class="text-end fw-bold text-danger fs-5">{{ number_format($cargo->total_fee, 2) }} ကျပ်</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-5 bg-light p-3 rounded">
                                <h6 class="fw-bold mb-3 border-bottom pb-2">ကုန်ပစ္စည်းအချက်အလက်</h6>
                                <div class="text-center mb-3 bg-white p-2 border">
                                    @if($cargo->media_id)
                                        <img src="{{ asset('storage/cargos/'.$cargo->media_id) }}" alt="cargo image" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                         <!--<img src="{{ public_asset($cargo_image) }}" alt="cargo image" class="img-thumbnail">-->
                                    @else
                                        <div class="py-5 text-muted bg-light"><i class="fas fa-box fa-3x"></i><br>ပုံမရှိပါ</div>
                                    @endif
                                </div>
                                <dl class="row">
                                    <dt class="col-sm-5 text-muted">ကုန်ပစ္စည်းအမှတ်</dt>
                                    <dd class="col-sm-7 fw-bold text-primary">{{ $cargo->cargo_no }}</dd>

                                    <dt class="col-sm-5 text-muted">ဘောက်ချာနံပါတ်</dt>
                                    <dd class="col-sm-7 fw-bold">{{ $cargo->voucher_number }}</dd>

                                    <dt class="col-sm-5 text-muted">ပို့ဆောင်မှုအမျိုးအစား</dt>
                                    <dd class="col-sm-7"><span class="badge bg-info text-white">{{ $cargo->delivery_type === 'gate' ? 'ဂိတ်အရောက်' : 'အိမ်အရောက်' }}</span></dd>

                                    <!--<dt class="col-sm-5 text-muted">ကုန်ပစ္စည်းအမျိုးအစား</dt>-->
                                    <!--<dd class="col-sm-7">{{ $cargo->cargoType?->name ?? 'သတ်မှတ်မထားပါ' }}</dd>-->
                                    <dt class="col-sm-4">ကုန်ပစ္စည်းအမျိုးအစား</dt>
                                    <dd class="col-sm-8">
                                        @if($cargo->cargoType)
                                            {{ $cargo->cargoType->name }}
                                        @elseif($cargo->items && $cargo->items->count() > 0)
                                            <!--{{-- Items table ထဲတွင် ရှိနေပါက ထိုမှတစ်ဆင့် ယူရန် --}}-->
                                            {{ $cargo->items->map(fn($item) => $item->cargoType?->name)->filter()->unique()->implode(', ') ?: 'သတ်မှတ်မထားပါ' }}
                                        @else
                                            သတ်မှတ်မထားပါ
                                        @endif
                                    </dd>

                                    <dt class="col-sm-5 text-muted">ကုန်ပစ္စည်းအသေးစိတ်</dt>
                                    <dd class="col-sm-7">{{ $cargo->cargo_detail_name ?: '-' }}</dd>

                                    <dt class="col-sm-5 text-muted">အရေအတွက်</dt>
                                    <dd class="col-sm-7 fw-bold">{{ $cargo->quantity }} ခု</dd>

                                    <dt class="col-sm-5 text-muted">ဂိတ်သွင်းကောင်တာ</dt>
                                    <dd class="col-sm-7">{{ $cargo->user?->name ?? 'Ko Ye' }}</dd>

                                    <dt class="col-sm-5 text-muted">လက်ရှိကောင်တာ</dt>
                                    <dd class="col-sm-7 text-success">{{ $cargo->fromGate?->name_my }}</dd>

                                    <dt class="col-sm-5 text-muted">ပစ္စည်းအခြေအနေ</dt>
                                    <dd class="col-sm-7"><span class="badge bg-warning">{{ $cargo->status }}</span></dd>

                                    <dt class="col-sm-5 text-muted">ကုန်စာရင်းသွင်းရက်</dt>
                                    <dd class="col-sm-7">{{ $cargo->created_at->format('d/m/Y') }}</dd>

                                    <dt class="col-sm-5 text-muted">ကုန်ရွေးရမည့်ရက်</dt>
                                    <dd class="col-sm-7">{{ $cargo->to_pick_date ? \Carbon\Carbon::parse($cargo->to_pick_date)->format('d/m/Y') : '-' }}</dd>
                                </dl>

                                @if($cargo->qrcode_image)
                                <div class="text-center mt-3">
                                    <img src="{{ asset('uploads/' . $cargo->qrcode_image) }}" alt="qrcode" class="img-thumbnail" style="width: 120px;">
                                    <p class="small text-muted mt-1">Scan for Info</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white text-end">
                        <a href="{{ route('admin.cargos.index') }}" class="btn btn-secondary px-4">နောက်သို့</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection