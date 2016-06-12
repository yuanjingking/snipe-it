@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
        	@lang('admin/hardware/form.update') ::

@parent
@stop

{{-- Page content --}}

@section('content')

<div class="row header">
    <div class="col-md-12">
            <a href="{{ URL::previous() }}" class="btn-flat gray pull-right right"><i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
        <h3>

        	@lang('admin/hardware/form.bulk_update')
        </h3>
    </div>
</div>

<div class="row form-wrapper">
            <!-- left column -->
            <div class="col-md-12 column">
	                <p>@lang('admin/hardware/form.bulk_update_help')</p>
	                <p style="color: red"><strong><big>@lang('admin/hardware/form.bulk_update_warn', ['asset_count' => count($assets)])</big></strong></p>


			 <form class="form-horizontal" method="post" action="{{ route('hardware/bulksave') }}" autocomplete="off" role="form">


            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />


 <!-- 设备类别 -->
          <div class="form-group {{ $errors->has('model_id') ? ' has-error' : '' }}">
                <label for="model_id" class="col-md-2 control-label">@lang('general.category') </label>
                <div class="col-md-7 col-sm-12">
                {{ Form::select('model_id', $model_list , Input::old('model_id'), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('model_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Supplier -->
            <div class="form-group {{ $errors->has('manufacturer_id') ? ' has-error' : '' }}">
                <label for="manufacturer_id" class="col-md-2 control-label">@lang('general.manufacturer')</label>
                <div class="col-md-7">
                    {{ Form::select('manufacturer_id', $manufacturer_list , Input::old('manufacturer_id'), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                    {{ $errors->first('manufacturer_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>


            @foreach ($assets as $key => $value)
            	<input type="hidden" name="bulk_edit[{{{ $key }}}]" value="1">
            @endforeach


            <!-- Form actions -->
                <div class="form-group">
                <label class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <a class="btn btn-link" href="{{ URL::previous() }}">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
                    </div>
                </div>

        </form>
    </div>
</div>
@stop
