@extends("la.layouts.app")

@section("contentheader_title", "Tematy prac magisterskich")
@section("contentheader_description", "Lista")
@section("section", "Tematy prac magisterskich")
@section("sub_section", "Lista")
@section("htmlheader_title", "Lista tematów prac magisterskich")

@section("headerElems")
@la_access("Magisters", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Dodaj temat pracy magisterskiej</button>
@endla_access
@endsection

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

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th> </th>
			@endif
		</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>

@la_access("Magisters", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Dodaj temat pracy magisterskiej</h4>
			</div>
			{!! Form::open(['action' => 'LA\MagistersController@store', 'id' => 'magister-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
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
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
				{!! Form::submit( 'Zapisz', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('laraadmin.adminRoute') . '/magister_dt_ajax') }}",
		language: {
			url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Polish.json"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#magister-add-form").validate({
		
	});
});
</script>
@endpush
