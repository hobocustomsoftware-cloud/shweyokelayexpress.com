@extends('admin.layouts.app')
@section('title', 'မြို့စာရင်းသွင်းမည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">မြို့စာရင်းသွင်းမည်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.cities.index') }}">မြို့စာရင်း</a></li>
                    <li class="breadcrumb-item active" aria-current="page">မြို့စာရင်းသွင်းမည်</li>
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
                    <h3 class="card-title">မြို့စာရင်းသွင်းမည်</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cities.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name_en">မြို့အမည်(အင်္ဂလိပ်) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name_en" id="name_en" >
                                    @error('name_en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">အကြောင်းအရာ</label>
                                    <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name_my">မြို့အမည်(မြန်မာ) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name_my" id="name_my" >
                                    @error('name_my')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="status">အခြေအနေ <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="status" id="status">
                                        <option value="active">အသုံးပြုနေသည်</option>
                                        <option value="inactive">အသုံးပြုမှုမရှိပါ</option>
                                    </select>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <a href="{{ route('admin.cities.index') }}" class="btn btn-sm btn-secondary">နောက်သို့</a>
                            <button type="submit" class="btn btn-sm btn-primary">ထည့်သွင်းမည်</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection
@if(session('success'))
@push('scripts')
<script>
    successMessageAlert('{{ session('success') }}');
</script>
@endpush
@endif