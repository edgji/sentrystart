@extends('sentrystart::layouts.default')

{{-- Web site Title --}}
@section('title')
{{trans('sentrystart::pages.login')}}
@stop

{{-- Content --}}
@section('content')
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        {{ Form::open(array('action' => 'Edgji\Sentrystart\SessionController@store')) }}

            <h2 class="form-signin-heading">{{trans('sentrystart::pages.login')}}</h2>

            <div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
                {{ Form::text('email', null, array('class' => 'form-control', 'placeholder' => trans('sentrystart::users.email'), 'autofocus')) }}
                {{ ($errors->has('email') ? $errors->first('email') : '') }}
            </div>

            <div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => trans('sentrystart::users.pword')))}}
                {{ ($errors->has('password') ?  $errors->first('password') : '') }}
            </div>
            
            <label class="checkbox">
                {{ Form::checkbox('rememberMe', 'rememberMe') }} {{trans('sentrystart::users.remember')}}?
            </label>
            {{ Form::submit(trans('sentrystart::pages.login'), array('class' => 'btn btn-primary'))}}
            <a class="btn btn-link" href="{{ route('forgotPasswordForm') }}">{{trans('sentrystart::users.forgot')}}?</a>
        {{ Form::close() }}
    </div>
</div>

@stop