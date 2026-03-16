@extends('admin.layouts.app')
@section('title', 'မြို့စာရင်းပြင်ဆင်မည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit City</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.cities.index') }}">City List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit City</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit City</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.cities.update', $city->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name_en">မြို့အမည်(EN) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_en" id="name_en"
                                            value="{{ $city->name_en ?? old('name_en', $city->name_en) }}">
                                        @error('name_en')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="description">အကြောင်းအရာ</label>
                                        <textarea class="form-control" name="description" id="description" rows="3">{{ $city->description ?? old('description', $city->description) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="name_my">မြို့အမည်(MY) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_my" id="name_my"
                                            value="{{ $city->name_my ?? old('name_my', $city->name_my) }}">
                                        @error('name_my')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label" for="status">အခြေအနေ</label>
                                        <select class="form-select select2" name="status" id="status">
                                            <option value="active" {{ $city->status == 'active' ? 'selected' : '' }}>
                                                အသုံးပြုနေသည်</option>
                                            <option value="inactive" {{ $city->status == 'inactive' ? 'selected' : '' }}>
                                                အသုံးပြုမှုမရှိပါ</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">နောက်သို့</a>
                            <button type="submit" class="btn btn-primary">ပြင်ဆင်မည်</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
