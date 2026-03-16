@extends('admin.layouts.app')
@section('title', 'ကုန်သည်ပြင်ဆင်မည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ကုန်သည်ပြင်ဆင်မည်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.merchants.index') }}">ကုန်သည်များ</a></li>
                    <li class="breadcrumb-item active">ကုန်သည်ပြင်ဆင်မည်</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">ကုန်သည်ပြင်ဆင်မည်</h3>
            </div>
            <form action="{{ route('admin.merchants.update', $merchant->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label class="form-label" for="name">အမည် <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $merchant->name }}" >
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="phone">ဖုန်း <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ $merchant->phone }}" >
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="nrc">မှတ်ပုံတင်အမှတ် </label>
                                <input type="text" class="form-control" id="nrc" name="nrc" value="{{ $merchant->nrc }}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="address">လိပ်စာ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ $merchant->address }}" >
                            </div>
                            <div class="form-group mb-3">
                                <a href="{{ route('admin.merchants.index') }}" class="btn btn-secondary">နောက်သို့</a>
                                <button type="submit" class="btn btn-primary">ပြင်ဆင်မည်</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection