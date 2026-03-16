@extends('admin.layouts.app')
@section('title', 'ရာထူးနှင့်ခွင့်ပြုချက်များ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">ရာထူးနှင့်ခွင့်ပြုချက်များ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active">ရာထူးနှင့်ခွင့်ပြုချက်များ</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">ရာထူးနှင့်ခွင့်ပြုချက်များ</div>
            <div class="card-body">
                @livewire('assign-permission-form')
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('PermissionAssigned', function() {
            successMessageAlert('{{ session('message') }}');
        });
    </script>
@endpush