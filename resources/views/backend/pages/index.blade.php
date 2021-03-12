@extends('backend.layouts.app')

@section('title', __('backend.pages'))

@push('css')
    <link href="{{ asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"/>
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">@lang('backend.dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('backend.pages')</li>
    </ol>
    <!-- end breadcrumb -->

    <!-- begin page-header -->
    <h1 class="page-header">@lang('backend.pages') </h1>
    <!-- end page-header -->

    <div class="d-block d-md-flex align-items-center mb-3">
        <div class="d-flex">
            <!-- begin btn-group -->
            <div class="btn-group">
                @include('backend.elements.top_buttons', [
                            'create_link'  => route('backend.pages.create'),
                            'name'         => __('backend.create_page'),
                            ])
            </div>
            <!-- end btn-group -->
        </div>
    </div>

    <!-- begin panel -->
    <div class="panel panel-success">
        <!-- begin panel-heading -->
        <div class="panel-heading">
            <h4 class="panel-title">@lang('backend.pages')</h4>
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
            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                <thead>
                <tr>
                    <th width="1%">#</th>
                    <th width="20%">@lang('backend.alias')</th>
                    <th width="40%">@lang('backend.title')</th>
                    <th width="10%" data-orderable="false">@lang('backend.active')</th>
                    <th width="30%" data-orderable="false"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($pages as $page)
                    <tr class="@if($loop->iteration  % 2 == 0) even @else odd @endif gradeA">
                        <td class="f-s-600 text-inverse">{{  $pages->firstItem() + $loop->index }}</td>
                        <td>{{ $page->alias }}</td>
                        <td>{{ $page->title }}</td>
                        <td>@if($page->active)
                                <span class="label label-success">@lang('backend.yes')</span>
                            @else
                                <span class="label label-default">@lang('backend.no')</span>
                            @endif
                        </td>
                        <td>
                            @include('backend.elements.edit_buttons', [
                                'edit_link'    => route('backend.pages.edit',['page'=> $page]),
                                'destroy_link' => route('backend.pages.destroy',['page' => $page]),
                                'page'        => $page,
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                    <tr class="gradeA">@lang('backend.nothing_found')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <!-- end panel-body -->
    </div>
    <!-- end panel -->
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
@endpush
