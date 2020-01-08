@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/magisters') }}">Edycja tematu pracy magisterskiej</a> :
@endsection
@section("contentheader_description", $magister->$view_col)
@section("section", "Tematy prac magisterskich")
@section("section_url", url(config('laraadmin.adminRoute') . '/magisters'))
@section("sub_section", "Edycja")

@section("htmlheader_title", "Edycja tematu pracy magisterskiej : ".$magister->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($magister, ['route' => [config('laraadmin.adminRoute') . '.magisters.update', $magister->id ], 'method'=>'PUT', 'id' => 'magister-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'promotor')
					@la_input($module, 'subject')
					@la_input($module, 'zakres')
					@la_input($module, 'aspekt')
					@la_input($module, 'oprogramowanie')
					@la_input($module, 'srodowisko')
					@la_input($module, 'dodatkowe')
					@la_input($module, 'literatura')
					@la_input($module, 'created_user')
					@la_input($module, 'created_at')
					@la_input($module, 'updated_user')
					@la_input($module, 'updated_at')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Zapisz', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/magisters') }}">Anuluj</a></button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#magister-edit-form").validate({
		
	});
});
</script>
@endpush
