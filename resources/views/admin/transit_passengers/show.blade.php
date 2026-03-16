@extends('admin.layouts.app')
@section('title', 'လမ်းတင်လူစာရင်းအသေးစိတ် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">လမ်းတင်လူစာရင်းအသေးစိတ်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.transit_passengers.index') }}">လမ်းတင်လူစာရင်းများ</a></li>
                    <li class="breadcrumb-item active">လမ်းတင်လူစာရင်းအသေးစိတ်</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">လမ်းတင်လူစာရင်းအသေးစိတ်</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">နာမည်</label>
                        <div class="form-control bg-light">{{ $transit_passenger->name }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">ဖုန်း</label>
                        <div class="form-control bg-light">{{ $transit_passenger->phone }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">နေရပ်လိပ်စာ</label>
                        <div class="form-control bg-light">{{ $transit_passenger->address }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">မှတ်ပုံတင်</label>
                        <div class="form-control bg-light">{{ $transit_passenger->nrc }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">ကားနံပါတ်</label>
                        <div class="form-control bg-light">{{ optional($transit_passenger->car)->number ?? '-' }}</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">ခုံနံပါတ်</label>
                        <div class="form-control bg-light">{{ $transit_passenger->seat_number }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">စျေးနှုန်း</label>
                        <div class="form-control bg-light">{{ number_format((float)($transit_passenger->price ?? 0)) }} Ks</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">နေ့စွဲ</label>
                        <div class="form-control bg-light">{{ optional($transit_passenger->created_at)->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('admin.transit_passengers.index') }}" class="btn btn-secondary">နောက်သို့</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
