@extends('admin.layouts.app')
@section('title', 'အစီရင်ခံစာအသေးစိတ် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">အစီရင်ခံစာအသေးစိတ်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">အစီရင်ခံစာများ</a></li>
                    <li class="breadcrumb-item active">အစီရင်ခံစာအသေးစိတ်</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid p-2">
        <!--begin::Row-->
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">အစီရင်ခံစာအသေးစိတ်</h3>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">ပို့သူအချက်အလက်</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">အမည်</dt>
                                    <dd class="col-sm-8">{{ $report->sender_name }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ဖုန်းနံပါတ်</dt>
                                    <dd class="col-sm-8">{{ $report->sender_phone }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">မှတ်ပုံတင်အမှတ်</dt>
                                    <dd class="col-sm-8">{{ $report->sender_nrc }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">လိပ်စာ</dt>
                                    <dd class="col-sm-8">{{ $report->sender_address }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">မှ မြို့နှင့်ဂိတ်</dt>
                                    <dd class="col-sm-8">{{ $report->from_city }} - {{ $report->from_gate }}</dd>
                                </dl>

                                <h6 class="mb-3">လက်ခံသူအချက်အလက်</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">အမည်</dt>
                                    <dd class="col-sm-8">{{ $report->receiver_name }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ဖုန်းနံပါတ်</dt>
                                    <dd class="col-sm-8">{{ $report->receiver_phone }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">မှတ်ပုံတင်အမှတ်</dt>
                                    <dd class="col-sm-8">{{ $report->receiver_nrc }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">လိပ်စာ</dt>
                                    <dd class="col-sm-8">{{ $report->receiver_address }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">သို့ မြို့နှင့်ဂိတ်</dt>
                                    <dd class="col-sm-8">{{ $report->to_city }} - {{ $report->to_gate }}</dd>
                                </dl>

                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">ကုန်ပစ္စည်းအချက်အလက်</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">ကုန်ပစ္စည်းအမှတ်</dt>
                                    <dd class="col-sm-8">{{ $report->cargo_no }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">အရေအတွက်</dt>
                                    <dd class="col-sm-8">{{ $report->quantity }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">ငွေကြေးအချက်လက်များ</h6>
                                <dl class="row">
                                    <dt class="col-sm-4">တန်ဆာခ</dt>
                                    <dd class="col-sm-8">{{ $report->service_charge }} ကျပ်</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ကုန်ကြွေး</dt>
                                    <dd class="col-sm-8">{{ $report->is_debt ? 'ကုန်ကြွေးကုန်ပစ္စည်း' : '' }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">ပစ္စည်းအခြေအနေ</dt>
                                    <dd class="col-sm-8">{{ $report->status }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ကုန်စာရင်းသွင်းရက်</dt>
                                    <dd class="col-sm-8">{{ $report->registered_date }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ကုန်ရွေးရမည့်ရက်</dt>
                                    <dd class="col-sm-8">{{ $report->to_pick_date }}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-4">ကားနံပါတ်</dt>
                                    <dd class="col-sm-8">{{ $report->car->number ?? '' }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">နောက်သို့</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end::Row-->
    </div>
</div>
@endsection