@extends('backend.layouts.app')

@section('title', __('backend.pages'))

@section('styles')
    <link href="{{ asset('assets/plugins/summernote/dist/summernote.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">@lang('backend.dashboard')</a></li>
        <li class="breadcrumb-item"><a href="{{ route('backend.templates.index') }}">@lang('backend.templates')</a></li>
        <li class="breadcrumb-item active">@lang('backend.create_new_template')</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">@lang('backend.create_new_template') </h1>
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
            </div>
        </div>
        <!-- end panel-body -->
    </div>
    <!-- end panel -->
@endsection
@section('js', 'templates')
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
            itemId: null,
            types: @json($field_types),
            categories: @json([]),
            resolutions: @json([]),
            tagSearchRoute: @json([]),
            route: @json(route('backend.templates.store')),
        }
    </script>
@endsection
