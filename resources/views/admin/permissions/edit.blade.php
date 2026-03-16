@extends('admin.layouts.app')
@section('title', 'ခွင့်ပြုချက်များစီမံခြင်းပြင်ဆင်မည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ခွင့်ပြုချက်များစီမံခြင်းပြင်ဆင်မည်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.permissions.index') }}">ခွင့်ပြုချက်များစီမံခြင်း</a></li>
                    <li class="breadcrumb-item active">ခွင့်ပြုချက်များစီမံခြင်းပြင်ဆင်မည်</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">ခွင့်ပြုချက်အမည် <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="cargo-create" value="{{ $permission->name }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">အကြောင်းအရာ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="ကုန်စာရင်းသွင်းခွင့်" value="{{ $permission->description }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">အခြေအနေ <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control">
                                <option value="active" {{ $permission->status == 'active' ? 'selected' : '' }}>အသုံးပြုနေသည်</option>
                                <option value="inactive" {{ $permission->status == 'inactive' ? 'selected' : '' }}>အသုံးပြုမှုမရှိပါ</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="float-end">
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">နောက်သို့</a>
                    <button type="submit" class="btn btn-primary">ပြင်မည်</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection