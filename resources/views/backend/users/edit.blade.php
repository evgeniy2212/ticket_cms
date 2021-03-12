@extends('backend.layouts.app')

@section('title', __('backend.edit_user'))

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">@lang('backend.dashboard')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('backend.users.index') }}">@lang('backend.user_managment')</a></li>
        <li class="breadcrumb-item active">@lang('backend.edit_user')</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">@lang('backend.edit_user') </h1>
    <!-- end page-header -->

    <!-- begin panel -->
    <div class="panel panel-success">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title"><i class="fas fa-user"></i></h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            </div>
        </div>
        <!-- end panel-heading -->

    @include('backend.elements.messages')

    <!-- begin panel-body -->
        <div class="panel-body">
            {!! Form::model($user, ['url' => route('backend.users.update',['user'=> $user]), 'class' => 'form-horizontal', 'method'=>'PUT','data-parsley-validate','autocomplete'=>'off']) !!}
            @include('backend.users.fields')
            {!! Form::close() !!}
        </div>
        <!-- end panel-body -->
    </div>
    <!-- end panel --
@endsection

