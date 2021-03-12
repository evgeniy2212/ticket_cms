<div class="col-xl-8 ui-sortable">
    <div class="form-group row m-b-15">
        <label class="col-md-3 col-sm-3 col-form-label text-lg-right" for="pageAlias">{{ __('backend.alias') }}:</label>
        <div class="col-md-9 col-sm-9">
            {{ Form::text('alias', (isset($template)) ? $template->alias : null, ['id'=>'pageAlias','class' => 'form-control','placeholder'=>__('backend.alias')]) }}
            <small>https://www.site.com/<strong>{{ __('backend.alias') }}</strong></small>
        </div>
    </div>
    <div class="form-group row m-b-15">
        <label class="col-md-3 col-sm-3 col-form-label text-lg-right" for="pageTitle">@lang('backend.page_title')* :</label>
        <div class="col-md-9 col-sm-9">
            {!! Form::text('title', (isset($template)) ? $template->title : null,['id'=>'pageTitle', 'class'=>'form-control','placeholder'=>__('backend.page_title'), 'required', 'data-parsley-required']) !!}
        </div>
    </div>
    <div class="form-group row m-b-15">
        <label class="col-md-3 col-sm-3 col-form-label text-lg-right" for="summernote">@lang('backend.page_content')* :</label>
        <div class="col-md-9 col-sm-9">
            {!! Form::textarea('text', (isset($template)) ? $template->text : null,['id'=>'summernote', 'class'=>'form-control','placeholder'=>__('backend.page_content'),'required', 'data-parsley-required']) !!}
        </div>
    </div>
    <div class="form-group row m-b-15">
        <label class="col-md-3 col-sm-3 col-form-label text-lg-right" for="active">@lang('backend.active'):</label>
        <div class="col-md-9 col-sm-9">
            {!! Form::hidden('active', 0) !!}
            <div class="switcher">
                {!! Form::checkbox('active', 1, (isset($template)) ? $template->active : null, ['id' => 'switcher-active']) !!}
                <label for="switcher-active"></label>
            </div>
        </div>
    </div>
    <div class="form-group row m-b-15 m-t-30">
        <label class="col-md-3 col-sm-3"></label>
        <div class="col-md-9 col-sm-9">
{{--            @include('backend.elements.save_buttons', ['back_link' => route('backend.pages.index')])--}}
        </div>
    </div>
</div>
