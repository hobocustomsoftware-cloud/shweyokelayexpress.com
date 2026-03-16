@extends('admin.layouts.app')
@section('title', 'အသုံးပြုသူအသစ်ထည့်မည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">အသုံးပြုသူများ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active">အသုံးပြုသူများ</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid p-2">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">အသုံးပြုသူအသစ်ထည့်မည်</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.users.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label" for="name">အမည် <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">အီးမေးလ် <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="password">ဝှတ်စာ <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="role">ရာထူးနေရာ <span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-control select2">
                                <option value="">အားလုံး</option>
                                @foreach ($roles as $id => $name)
                                    <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">နောက်သို့</a>
                            <button type="submit" class="btn btn-primary">သိမ်းမည်</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection