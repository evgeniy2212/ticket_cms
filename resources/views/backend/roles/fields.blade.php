<div class="col-xl-6 ui-sortable">
    <div class="form-group row m-b-15">
        <label class="col-md-4 col-sm-4 col-form-label text-lg-right" for="userCreateName">@lang('backend.name'):</label>
        <div class="col-md-8 col-sm-8">
            {!! Form::text('name', null,['id'=>'roleName', 'class'=>'form-control','placeholder'=>__('backend.name'), 'required', 'data-parsley-required']) !!}
        </div>
    </div>
    <div class="form-group row m-b-15">
        <label class="col-md-4 col-sm-4 col-form-label text-lg-right" for="active">@lang('backend.active'):</label>
        <div class="col-md-8 col-sm-8">
            {!! Form::hidden('active', 0) !!}
            <div class="switcher">
                {!! Form::checkbox('active', 1, null, ['id' => 'switcher-active']) !!}
                <label for="switcher-active"></label>
            </div>
        </div>
    </div>
    <div class="form-group row m-b-15">
        <label class="col-md-4 col-sm-4 col-form-label text-lg-right" for="active">@lang('backend.permissions'):</label>
        <div class="col-md-8 col-sm-8">
            <div class="form-check">
                @foreach($permissions as $permission)
                    <div>
                        {!! Form::checkbox('roles[]', $permission->name, isset($role) && $role->hasPermissionTo($permission->name), ['id' => 'permission-'.$permission->id]) !!}
                        <label for="permission-{{$permission->id}}">{{$permission->name}}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="form-group row m-b-15 m-t-30">
        <label class="col-md-4 col-sm-4"></label>
        <div class="col-md-8 col-sm-8">
            @include('backend.elements.save_buttons', ['back_link' => route('backend.roles.index')])
        </div>
    </div>
</div>
