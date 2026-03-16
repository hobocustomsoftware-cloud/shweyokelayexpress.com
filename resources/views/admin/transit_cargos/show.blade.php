@extends('admin.layouts.app')
@section('title', 'လမ်းတင်ကုန်ပစ္စည်းအကြောင်း အသေးစိတ် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ကုန်ပစ္စည်းအကြောင်း အသေးစိတ်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.transit_cargos.index') }}">ကုန်ပစ္စည်းများ</a></li>
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
                                    <dd class="col-sm-8">{{ $transit_cargo->s_name }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ဖုန်းနံပါတ်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->s_phone }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">မှတ်ပုံတင်အမှတ်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->s_nrc }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">လိပ်စာ</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->s_address }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">မှ မြို့နှင့်ဂိတ်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->fromCity->name_my }} - {{ $transit_cargo->fromGate->name_my }}</dd>
                                </dl>

                                <h6 class="mb-3">လက်ခံသူအချက်အလက်</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">အမည်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->name }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ဖုန်းနံပါတ်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->r_phone }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">မှတ်ပုံတင်အမှတ်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->r_nrc }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">လိပ်စာ</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->r_address }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">သို့ မြို့နှင့်ဂိတ်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->toCity->name_my }} - {{ $transit_cargo->toGate->name_my }}</dd>
                                </dl>

                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">ကုန်ပစ္စည်းအချက်အလက်</h6>
                                <div class="image-container mb-3">
                                    <img src="{{ public_asset($transit_cargo_image) }}" alt="transit_cargo image" class="img-fluid">
                                </div>
                                <dl class="row">
                                    <dt class="col-sm-4">ကုန်ပစ္စည်းအမှတ်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->transit_cargo_no }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ဘောက်ချာနံပါတ်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->voucher_number }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ကုန်ပစ္စည်းအမျိုးအစား</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->cargoType->name }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">အရေအတွက်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->quantity }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">မှတ်ချက်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->note }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ဂိတ်သွင်းကောင်တာ</dt>
                                    <dd class="col-sm-8">{{ $user->name }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">ငွေကြေးအချက်လက်များ</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">တန်ဆာခ</dt>
                                    <dd class="col-sm-8">{{ $service_charge }} ကျပ်</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ကုန်ကြွေး</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->is_debt ? 'ကုန်ကြွေးကုန်ပစ္စည်း' : '' }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">လက်ရှိကောင်တာ</dt>
                                    <dd class="col-sm-8">{{$transit_cargo->fromGate->name_my}}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ပစ္စည်းအခြေအနေ</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo_status }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ကုန်စာရင်းသွင်းရက်</dt>
                                    <dd class="col-sm-8">{{ $entry_date ?? '' }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ကုန်ရွေးရမည့်ရက်</dt>
                                    <dd class="col-sm-8">{{ $to_take_date ?? '' }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ကားနံပါတ်</dt>
                                    <dd class="col-sm-8">{{ $transit_cargo->car->number ?? '' }}</dd>
                                </dl>
                                @if($qrcode_image)
                                <dl class="row">
                                    <div class="col-md-6">
                                        <img src="{{ public_asset('uploads/' . $qrcode_image) }}" alt="qrcode" class="img-thumbnail">
                                    </div>
                                </dl>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <a href="{{ route('admin.transit_cargos.index') }}" class="btn btn-secondary">နောက်သို့</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection