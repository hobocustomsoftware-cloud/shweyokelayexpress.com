@extends('admin.layouts.app')
@section('title', 'ကုန်အမျိုးအစားပြင်ဆင်မည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ကုန်အမျိုးအစားပြင်ဆင်မည်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{route('admin.cargo_types.index')}}">ကုန်အမျိုးအစားများ</a> </li>
                    <li class="breadcrumb-item active">ကုန်အမျိုးအစားပြင်ဆင်မည်</li>
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
                    <div class="card-title">
                        <h3 class="card-title">ကုန်အမျိုးအစားပြင်ဆင်မည်</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.cargo_types.update', $cargoType->id)}}" method="POST" id="cargoTypeForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" value="{{$cargoType->id}}">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="name">အမည် <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{$cargoType->name}}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">ဖော်ပြချက် <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-2 mb-2">
                                        <button type="button" class="btn btn-outline-primary rec-btn" data-desc="ရေမစိုရ" data-toggle="tooltip" data-placement="top" title="Recommendation 1">
                                            ရေမစိုရ
                                        </button>
                                        <button type="button" class="btn btn-outline-primary rec-btn" data-desc="မပေါက်မပြဲစေရ" data-toggle="tooltip" data-placement="top" title="Recommendation 2">
                                            မပေါက်မပြဲစေရ
                                        </button>
                                        <button type="button" class="btn btn-outline-primary rec-btn" data-desc="မကျိူးမပဲ့စေရ" data-toggle="tooltip" data-placement="top" title="Recommendation 3">
                                            မကျိူးမပဲ့စေရ
                                        </button>
                                        <button type="button" class="btn btn-outline-primary rec-btn" data-desc="မပြဲစေရ" data-toggle="tooltip" data-placement="top" title="Recommendation 4">
                                            မပြဲစေရ
                                        </button>
                                    </div>
                                    <input type="text" name="description" class="form-control" id="description" value="{{$cargoType->description}}">
                                    @error('description')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label" for="status">အခြေအနေ <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control" value="{{$cargoType->status}}">
                                        <option value="active" {{$cargoType->status === 'active' ? 'selected' : ''}}>အသုံးပြုနေသည်</option>
                                        <option value="inactive" {{$cargoType->status === 'inactive' ? 'selected' : ''}}>အသုံးပြုမှုမရှိသည်</option>
                                    </select>
                                </div>
                                <a href="{{route('admin.cargo_types.index')}}" class="btn btn-sm btn-secondary">နောက်သို့</a>
                                <button type="submit" class="btn btn-sm btn-primary">ပြင်ဆင်မည်</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const recBtns = document.querySelectorAll('.rec-btn');
        const description = document.getElementById('description');

        recBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const desc = this.getAttribute('data-desc');
                const descArr = desc.split('/');
                const formattedDesc = descArr.join(' / ');

                if (description.value) {
                    description.value += ', ' + formattedDesc;
                } else {
                    description.value = formattedDesc;
                }
            });
        });
    });
</script>
@endpush