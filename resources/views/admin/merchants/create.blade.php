@extends('admin.layouts.app')
@section('title', 'ကုန်သည်အသစ်ထည့်မည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">ကုန်သည်အသစ်ထည့်မည်</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.merchants.index') }}">ကုန်သည်များ</a></li>
                        <li class="breadcrumb-item active">ကုန်သည်အသစ်ထည့်မည်</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid p-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ကုန်သည်အသစ်ထည့်မည်</h3>
                </div>
                <form action="{{ route('admin.merchants.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">အမည် <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name">
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="phone">ဖုန်းနံပါတ် <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="nrc">မှတ်ပုံတင်အမှတ် </label>
                                    <input type="text" class="form-control" id="nrc" name="nrc">
                                    @error('nrc')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="address">လိပ်စာ </label>
                                    <textarea name="address" id="address" rows="3" class="form-control"></textarea>
                                    @error('address')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <a href="{{ route('admin.merchants.index') }}" class="btn btn-secondary">နောက်သို့</a>
                                    <button type="submit" class="btn btn-primary">ထည့်သွင်းမည်</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
