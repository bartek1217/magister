@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/magisters') }}">Edycja tematu pracy licencjackiej</a> :
@endsection
@section("contentheader_description", $licencjat->$view_col)
@section("section", "Tematy prac licencjackich")
@section("section_url", url(config('laraadmin.adminRoute') . '/licencjats'))
@section("sub_section", "Edycja")

@section("htmlheader_title", "Edycja tematu pracy licencjackiej : ".$licencjat->$view_col)

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
				{!! Form::model($licencjat, ['route' => [config('laraadmin.adminRoute') . '.licencjats.update', $licencjat->id ], 'method'=>'PUT', 'id' => 'licencjat-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'promotor')
					@la_input($module, 'subject')
					@la_input($module, 'zakres')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Zapisz', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/licencjats') }}">Anuluj</a></button>
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
	$("#licencjat-edit-form").validate({
		
	});
});
</script>
@endpush
