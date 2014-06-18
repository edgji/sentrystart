@extends('sentrystart::layouts.default')

{{-- Web site Title --}}
@section('title')
@parent
{{trans('sentrystart::groups.create')}}
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
	{{ Form::open(array('action' => 'Edgji\Sentrystart\GroupController@store')) }}
        <h2>{{trans('sentrystart::groups.create')}}</h2>
    
        <div class="form-group {{ ($errors->has('name')) ? 'has-error' : '' }}">
            {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => trans('sentrystart::groups.name'))) }}
            {{ ($errors->has('name') ? $errors->first('name') : '') }}
        </div>

        {{ Form::label(trans('sentrystart::groups.permisions')) }}
        <div class="form-group">
            <label class="checkbox-inline">
                {{ Form::checkbox('adminPermissions', 1) }} Admin
            </label>
            <label class="checkbox-inline">
                {{ Form::checkbox('userPermissions', 1) }} User
            </label>

        </div>

        {{ Form::submit(trans('sentrystart::groups.create'), array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
    </div>
</div>

@stop