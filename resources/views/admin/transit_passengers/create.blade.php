@extends('admin.layouts.app')
@section('title', 'လမ်းတင်လူစာရင်းသွင်းမည် | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">လမ်းတင်လူစာရင်းသွင်းမည်</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.transit_passengers.index') }}">လမ်းတင်လူစာရင်းများ</a></li>
                    <li class="breadcrumb-item active">လမ်းတင်လူစာရင်းသွင်းမည်</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    @livewire('transit-passenger-form', ['form_type' => 'create', 'id' => null])
</div>
@endsection