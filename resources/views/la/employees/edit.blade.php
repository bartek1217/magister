@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/employees') }}">Użytkownik</a> :
@endsection
@section("contentheader_description", $employee->$view_col)
@section("section", "Użytkownicy")
@section("section_url", url(config('laraadmin.adminRoute') . '/employees'))
@section("sub_section", "Edycja")

@section("htmlheader_title", "Edycja użytkownika : ".$employee->$view_col)

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
				{!! Form::model($employee, ['route' => [config('laraadmin.adminRoute') . '.employees.update', $employee->id ], 'method'=>'PUT', 'id' => 'employee-edit-form']) !!}
					@la_input($module, 'name')
					@la_input($module, 'designation')
					@la_input($module, 'email')
					@la_input($module, 'dept')

                    <div class="form-group">
						<label for="role">Rola* :</label>
						<select class="form-control" required="1" data-placeholder="Select Role" rel="select2" name="role">
							<?php $roles = App\Role::all(); ?>
							@foreach($roles as $role)
								@if($role->id != 1 || Entrust::hasRole("SUPER_ADMIN"))
									@if($user->hasRole($role->name))
										@if($role->id != 1)
											<option value="{{ $role->id }}" selected>{{ $role->name }}</option>
										@endif
									@else
										@if($role->id != 1)
											<option value="{{ $role->id }}">{{ $role->name }}</option>
										@endif
									@endif
								@endif
							@endforeach
						</select>
					</div>
					<br>
					<div class="form-group">
						{!! Form::submit( 'Zapisz', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/employees') }}">Anuluj</a></button>
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
	$("#employee-edit-form").validate({
		
	});
});
</script>
@endpush
