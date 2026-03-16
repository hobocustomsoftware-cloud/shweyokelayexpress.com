@extends('admin.layouts.app')
@section('title', 'ဂိတ်ပြင်ဆင်မည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ဂိတ်ပြင်ဆင်မည်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ဂိတ်ပြင်ဆင်မည်</li>
                </ol>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<div class="app-content">
    <div class="container-fluid p-2">
        <!--begin::Row-->
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ဂိတ်ပြင်ဆင်မှူ</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.gates.update', $gate) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name_my">ဂိတ်အမည် <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name_my" name="name_my" value="{{ $gate->name_my }}" >
                                    @error('name_my')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name_en">ဂိတ်အမည်(EN) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name_en" name="name_en" value="{{ $gate->name_en }}"> 
                                    @error('name_en')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="city_id">မြို့အမည် <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm select2" id="city_id" name="city_id">
                                        <option value="">ရွေးမည်</option>
                                        @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $city->id == $gate->city_id ? 'selected' : '' }}>{{ $city->name_my }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="is_main">ပင်မဂိတ် <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm select2" id="is_main" name="is_main">
                                        <option value="1" {{ $gate->is_main ? 'selected' : '' }}>ပင်မဂိတ်</option>
                                        <option value="0" {{ !$gate->is_main ? 'selected' : '' }}>ဂိတ်ခွဲ</option>
                                    </select>
                                    @error('is_main')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="is_transit">ဂိတ်ချိန်း <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm select2" id="is_transit" name="is_transit">
                                        <option value="1" {{ $gate->is_transit ? 'selected' : '' }}>ဟုတ်တယ်</option>
                                        <option value="0" {{ !$gate->is_transit ? 'selected' : '' }}>မဟုတ်ပါ</option>
                                    </select>
                                    @error('is_transit')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">အကြောင်းရာ</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" >{{ $gate->description }}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.gates.index') }}" class="btn btn-sm btn-secondary">Cancle</a>
                        <button type="submit" class="btn btn-sm btn-primary">ဂိတ်ပြင်ဆင်မည်</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection