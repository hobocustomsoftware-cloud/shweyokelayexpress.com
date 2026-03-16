@extends('admin.layouts.app')
@section('title', 'အေဂျင့်ကောင်တာများ | Shweyokelay Cargo')
@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">အေဂျင့်ကောင်တာများ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ပင်မစာမျက်နှာ</a></li>
                    <li class="breadcrumb-item active">အေဂျင့်ကောင်တာများ</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection