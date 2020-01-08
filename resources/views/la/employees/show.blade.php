@extends('la.layouts.app')

@section('htmlheader_title')
	Lita użytkowników
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-success clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<img class="profile-image" src="{{ Gravatar::fallback(asset('/img/avatar5.png'))->get(Auth::user()->email, ['size'=>400]) }}" alt="">
				</div>
				<div class="col-md-9">
					<h4 class="name">{{ $employee->$view_col }}</h4>
				</div>
			</div>
		</div>
		<div class="col-md-1 actions">
			@la_access("Employees", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/employees/'.$employee->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			
			@la_access("Employees", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.employees.destroy', $employee->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/employees') }}" data-toggle="tooltip" data-placement="right" title="Wróć do listy użytkowników"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-info" data-target="#tab-info"><i class="fa fa-bars"></i> Szczegółowe informacje</a></li>
		<li class=""><a role="tab" data-toggle="tab" href="#tab-timeline" data-target="#tab-timeline"><i class="fa fa-list-alt"></i> Tematy prac dyplomowych</a></li>
		@if($employee->id == Auth::user()->id || Entrust::hasRole("SUPER_ADMIN"))
			<li class=""><a role="tab" data-toggle="tab" href="#tab-account-settings" data-target="#tab-account-settings"><i class="fa fa-key"></i> Zmiana hasła</a></li>
		@endif
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>Szczdegóły użytkownika</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'name')
						{{--@la_display($module, 'designation')
						@la_display($module, 'gender')
						@la_display($module, 'mobile')
						@la_display($module, 'mobile2')
						@la_display($module, 'email')
						@la_display($module, 'dept')
						@la_display($module, 'city')
						@la_display($module, 'address')
						@la_display($module, 'about')
						@la_display($module, 'date_birth')
						@la_display($module, 'date_hire')
						@la_display($module, 'date_left')
						@la_display($module, 'salary_cur')--}}
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
			<div class="tab-content">
			<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>Lista tematów prac licencjackich: </h4>
					</div>
					<div class="panel-body">
						<table class="table table-hover">
							<thead>
								<tr>
								<th scope="col">Temat</th>
								<th scope="col">Status</th>
								@if(Entrust::hasRole("PRACOWNIK") || Entrust::hasRole("ADMINISTRATOR"))
								<th scope="col">Student</th>
								<th scope="col">Proponowany recenzent</th>
								<th scope="col">Recenzent</th>
								@endif
								</tr>
							</thead>
							<tbody>
								@foreach ($licencjats as $licencjat)
								<tr>
								<th scope="row"> {{ $licencjat->subject }} </th>
								<td>{{ $licencjat->status }}</td>
								@if(Entrust::hasRole("PRACOWNIK") || Entrust::hasRole("ADMINISTRATOR"))
								<td>{{ $licencjat->student }}</td>
								<td>{{ $licencjat->prop_recenzent }}</td>
								<td>{{ $licencjat->recenzent }}</td>
								@endif
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>Lista tematów prac magisterskich: </h4>
					</div>
					<div class="panel-body">
						<table class="table table-hover">
							<thead>
								<tr>
								<th scope="col">Temat</th>
								<th scope="col">Status</th>
								@if(Entrust::hasRole("PRACOWNIK") || Entrust::hasRole("ADMINISTRATOR"))
								<th scope="col">Student</th>
								<th scope="col">Proponowany recenzent</th>
								<th scope="col">Recenzent</th>
								@endif
								</tr>
							</thead>
							<tbody>
								@foreach ($magisters as $magister)
								<tr>
								<th scope="row"> {{ $magister->subject }} </th>
								<td>{{ $magister->status }}</td>
								@if(Entrust::hasRole("PRACOWNIK") || Entrust::hasRole("ADMINISTRATOR"))
								<td>{{ $magister->student }}</td>
								<td>{{ $magister->prop_recenzent }}</td>
								<td>{{ $magister->recenzent }}</td>
								@endif
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		@if($employee->id == Auth::user()->id || Entrust::hasRole("SUPER_ADMIN"))
		<div role="tabpanel" class="tab-pane fade" id="tab-account-settings">
			<div class="tab-content">
				<form action="{{ url(config('laraadmin.adminRoute') . '/change_password/'.$employee->id) }}" id="password-reset-form" class="general-form dashed-row white" method="post" accept-charset="utf-8">
					{{ csrf_field() }}
					<div class="panel">
						<div class="panel-default panel-heading">
							<h4>Zmiana hasła</h4>
						</div>
						<div class="panel-body">
							@if (count($errors) > 0)
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							@if(Session::has('success_message'))
								<p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success_message') }}</p>
							@endif
							<div class="form-group">
								<label for="password" class=" col-md-2">Hasło</label>
								<div class=" col-md-10">
									<input type="password" name="password" value="" id="password" class="form-control" placeholder="Hasło" autocomplete="off" required="required" data-rule-minlength="6" data-msg-minlength="Wprowadź przynajmniej 6 znaków.">
								</div>
							</div>
							<div class="form-group">
								<label for="password_confirmation" class=" col-md-2">Powtórz hasło</label>
								<div class=" col-md-10">
									<input type="password" name="password_confirmation" value="" id="password_confirmation" class="form-control" placeholder="Powtórz hasło" autocomplete="off" required="required" data-rule-equalto="#password" data-msg-equalto="Wprowadź ponownie to samo hasło.">
								</div>
							</div>
						</div>
						<div class="panel-footer">
							<button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> Zmień hasło</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		@endif
	</div>
	</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
	@if($employee->id == Auth::user()->id || Entrust::hasRole("SUPER_ADMIN"))
	$('#password-reset-form').validate({
		
	});
	@endif
});
</script>
@endpush
