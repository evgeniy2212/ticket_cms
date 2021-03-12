@extends('backend.layouts.app')

@section('title', __('backend.pages'))

@section('styles')
    <link href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">@lang('backend.dashboard')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('backend.pages.index') }}">@lang('backend.pages')</a></li>
        <li class="breadcrumb-item active">@lang('backend.create_new_page')</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">@lang('backend.create_new_page') </h1>
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
            <div id="app" class="news-block"  class="mb-5">
                <action-bar></action-bar>
                <editor v-show="showEditor"></editor>
{{--                <settings v-show="showSettings"></settings>--}}
            </div>
{{--            {!! Form::open([--}}
{{--                'url' => route('backend.pages.store'),--}}
{{--                'class' => 'form-horizontal',--}}
{{--                'method'=>'POST',--}}
{{--                'data-parsley-validate',--}}
{{--                'autocomplete'=>'off'--}}
{{--            ]) !!}--}}
{{--            @include('backend.pages.fields')--}}
{{--            {!! Form::close() !!}--}}
        </div>
        <!-- end panel-body -->
    </div>
    <!-- end panel -->
@endsection
@section('js', 'pages')
@section('scripts')
    <script src="{{ asset('assets/plugins/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/summernote/dist/summernote.min.js') }}"></script>
    <script>
        var handleSummernote = function() {
            $('#summernote').summernote({
                placeholder: '',
                tabsize: 2,
                height: 300,
            });
        };

        var FormSummernote = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleSummernote();
                }
            };
        }();

        $(document).ready(function() {
            FormSummernote.init();
        });
    </script>
    <script>
        window.shared = {
            newsId: null,
            types: @json($block_types),
            authors: @json([]),
            categories: @json([]),
            resolutions: @json([]),
            tagSearchRoute: @json([]),
            newsRoute: @json([]),
        }
    </script>
@endsection
