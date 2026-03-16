@extends('admin.layouts.app')
@section('title', 'အသုံးပြုသူအချက်အလက်များ | ရွှေရုပ်လေး ကားလိုင်း')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">အသုံးပြုသူအချက်အလက်များ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">အသုံးပြုသူများ</a> </li>
                    <li class="breadcrumb-item active">အသုံးပြုသူအချက်အလက်များ</li>
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
                        <h3 class="card-title">အသုံးပြုသူအချက်အလက်များ</h3>
                    </div>
                </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="row">
                                    <dt class="col-sm-4">အမည်</dt>
                                    <dd class="col-sm-8">{{ $user->name }}</dd>
                                    <dt class="col-sm-4">အီးမေးလ်</dt>
                                    <dd class="col-sm-8">{{ $user->email }}</dd>
                                    <dt class="col-sm-4">တာဝန်ယူမှုများ</dt>
                                    <dd class="col-sm-8">{{ $user->getRoleNames()->first() }}</dd>
                                    <dt class="col-sm-4">အခြေအနေ</dt>
                                    <dd class="col-sm-8">{{ $user->status }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('admin.users.index')}}" class="btn btn-secondary">နောက်သို့</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection