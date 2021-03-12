@extends('backend.layouts.app')

@section('title', __('backend.create_new_role'))

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">@lang('backend.dashboard')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('backend.roles.index') }}">@lang('backend.roles')</a></li>
        <li class="breadcrumb-item active">@lang('backend.create_new_role')</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">@lang('backend.create_new_role') </h1>
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
            {!! Form::open([
                'url' => route('backend.roles.store'),
                'class' => 'form-horizontal',
                'method'=>'POST',
                'data-parsley-validate' => true,
                'autocomplete'=>'off'
            ]) !!}
            @include('backend.roles.fields')
            {!! Form::close() !!}
        </div>
        <!-- end panel-body -->
    </div>
    <!-- end panel -->
@endsection

@section('scripts')
    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    <script src="{{ asset('assets/plugins/parsleyjs/dist/parsley.min.js') }}"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
@endsection
