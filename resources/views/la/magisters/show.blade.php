@extends('la.layouts.app')

@section('htmlheader_title')
	Szczegóły tematu pracy magisterskiej
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">{{ $magister->$view_col }}</h4>
					<div class="row stats">

					</div>
					<p class="desc">Szczegóły tematu pracy magisterskiej</p>
				</div>
			</div>
		</div>
		<div class="col-md-3">

		</div>
		<div class="col-md-4">


		</div>
		<div class="col-md-1 actions">
			@la_access("Magisters", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/magisters/'.$magister->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			
			@la_access("Magisters", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.magisters.destroy', $magister->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/magisters') }}" data-toggle="tooltip" data-placement="right" title="Powrót do listy z tematami prac magisterskich"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> Szczegóły</a></li>
		@if(Entrust::hasRole("STUDENT") && $magister->stan == '0')
		<li class=""><a role="tab" data-toggle="tab" href="#tab-reservation" data-target="#tab-reservation"><i class="fa fa-clock-o"></i> Zarezerwuj temat</a></li>
		@endif
		@if($magister->stan == '1' && ((Entrust::hasRole("PRACOWNIK") && $magister->promotor == Auth::user()->id) || Entrust::hasRole("ADMINISTRATOR")))
			<li class=""><a role="tab" data-toggle="tab" href="#tab-confirm-reservation" data-target="#tab-confirm-reservation"><i class="fa fa-check-square-o"></i> Potwierdź rezerwację</a></li>
		@endif
		@if($magister->stan != '0'&& ((Entrust::hasRole("STUDENT") && $magister->student == Auth::user()->id) || (Entrust::hasRole("PRACOWNIK") && $magister->promotor == Auth::user()->id) || Entrust::hasRole("ADMINISTRATOR")))
			<li class=""><a role="tab" data-toggle="tab" href="#tab-delete-reservation" data-target="#tab-delete-reservation"><i class="fa fa-trash-o"></i> Usuń rezerwację</a></li>
		@endif
		@if($magister->stan == '0' && ((Entrust::hasRole("PRACOWNIK") && $magister->promotor == Auth::user()->id) || Entrust::hasRole("ADMINISTRATOR")))
			<li class=""><a role="tab" data-toggle="tab" href="#tab-add-reservation" data-target="#tab-add-reservation"><i class="fa fa-plus"></i> Przypisz studenta do tematu</a></li>
		@endif
		@if($magister->stan == '2' && Entrust::hasRole("PRACOWNIK") && $magister->promotor == Auth::user()->id)
			<li class=""><a role="tab" data-toggle="tab" href="#tab-prop-recenzent" data-target="#tab-prop-recenzent"><i class="fa fa-user-plus"></i> Zaproponuj recenzenta</a></li>
		@endif
		@if($magister->stan == '2' && Entrust::hasRole("ADMINISTRATOR"))
			<li class=""><a role="tab" data-toggle="tab" href="#tab-add-recenzent" data-target="#tab-add-recenzent"><i class="fa fa-user-plus"></i> Dodaj recenzenta</a></li>
		@endif
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>Szczegóły</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'promotor')
						@la_display($module, 'subject')
						@la_display($module, 'zakres')
						@la_display($module, 'aspekt')
						@la_display($module, 'oprogramowanie')
						@la_display($module, 'srodowisko')
						@la_display($module, 'dodatkowe')
						@la_display($module, 'literatura')
						@la_display($module, 'status')
						@la_display($module, 'student')
						@la_display($module, 'prop_recenzent')
						@la_display($module, 'recenzent')
						@la_display($module, 'created_user')
						@la_display($module, 'created_at')
						@la_display($module, 'updated_user')
						@la_display($module, 'updated_at')
					</div>
				</div>
			</div>
		</div>
		@if(Entrust::hasRole("STUDENT") && $magister->stan == '0')
			<div role="tabpanel" class="tab-pane fade in" id="tab-reservation">
				<div class="tab-content">
					<div class="panel infolist">
						<div class="panel-default panel-heading">
							<h4>Rezerwacja tematu: {{ $magister->$view_col }} </h4>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<button class="btn btn-default pull-left"><a href="{{ url(config('laraadmin.adminRoute') . '/magister/reservation/' . $magister->id) }}">Zarezerwuj temat</a></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
		@if((Entrust::hasRole("PRACOWNIK") && $magister->promotor == Auth::user()->id) || Entrust::hasRole("ADMINISTRATOR"))
			<div role="tabpanel" class="tab-pane fade in" id="tab-confirm-reservation">
				<div class="tab-content">
					<div class="panel infolist">
						<div class="panel-default panel-heading">
							<h4>Potwierdź rezerwację tematu: {{ $magister->$view_col }} </h4>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<button class="btn btn-default pull-left"><a href="{{ url(config('laraadmin.adminRoute') . '/magister/confirm-reservation/' . $magister->id) }}">Potwierdzam rezerwację</a></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
		@if($magister->stan != '0'&& ((Entrust::hasRole("STUDENT") && $magister->student == Auth::user()->id) || (Entrust::hasRole("PRACOWNIK") && $magister->promotor == Auth::user()->id) || Entrust::hasRole("ADMINISTRATOR")))
			<div role="tabpanel" class="tab-pane fade in" id="tab-delete-reservation">
				<div class="tab-content">
					<div class="panel infolist">
						<div class="panel-default panel-heading">
							<h4>Usuń rezerwację tematu: {{ $magister->$view_col }} </h4>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<button class="btn btn-default pull-left"><a href="{{ url(config('laraadmin.adminRoute') . '/magister/delete-reservation/' . $magister->id) }}">Usuń rezerwację</a></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
		@if($magister->stan == '0' && ((Entrust::hasRole("PRACOWNIK") && $magister->promotor == Auth::user()->id) || Entrust::hasRole("ADMINISTRATOR")))
			<div role="tabpanel" class="tab-pane fade in" id="tab-add-reservation">
				<div class="tab-content">
				<form action="{{ url(config('laraadmin.adminRoute') . '/magister/add-reservation/' . $magister->id) }}" id="password-reset-form" class="general-form dashed-row white" method="post" accept-charset="utf-8">
					{{ csrf_field() }}
					<div class="panel">
						<div class="panel-default panel-heading">
							<h4>Dodaj studenta do tematu : {{ $magister->$view_col }} </h4>
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
								<label for="student" class=" col-md-2">Student</label>
								<select class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="student">
								@foreach($students as $student)
								<option value="{{ $student->id }}">{{ $student->name }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="panel-footer">
							<button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> Dodaj studenta</button>
						</div>
					</div>
				</form>
			</div>
			</div>
		@endif
		@if($magister->stan == '2' && Entrust::hasRole("PRACOWNIK") && $magister->promotor == Auth::user()->id)
			<div role="tabpanel" class="tab-pane fade in" id="tab-prop-recenzent">
				<div class="tab-content">
				<form action="{{ url(config('laraadmin.adminRoute') . '/magister/add-reservation/' . $magister->id) }}" id="password-reset-form" class="general-form dashed-row white" method="post" accept-charset="utf-8">
					{{ csrf_field() }}
					<div class="panel">
						<div class="panel-default panel-heading">
							<h4>Dodaj proponowanego recenzenta do tematu : {{ $magister->$view_col }} </h4>
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
								<label for="recenzent" class=" col-md-2">Proponowany recenzent:</label>
								<select class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="student">
								@foreach($recenzents as $recenzent)
								<option value="{{ $recenzent->id }}">{{ $recenzent->name }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="panel-footer">
							<button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> Dodaj recenzenta</button>
						</div>
					</div>
				</form>
			</div>
			</div>
		@endif		
		@if($magister->stan == '2' && Entrust::hasRole("ADMINISTRATOR"))
			<div role="tabpanel" class="tab-pane fade in" id="tab-add-recenzent">
				<div class="tab-content">
				<form action="{{ url(config('laraadmin.adminRoute') . '/magister/add-reservation/' . $magister->id) }}" id="password-reset-form" class="general-form dashed-row white" method="post" accept-charset="utf-8">
					{{ csrf_field() }}
					<div class="panel">
						<div class="panel-default panel-heading">
							<h4>Dodaj recenzenta do tematu : {{ $magister->$view_col }} </h4>
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
							@la_display($module, 'prop_recenzent')
							<div class="form-group">
								<label for="recenzent" class=" col-md-2">Recenzent:</label>
								<select class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="student">
								@foreach($recenzents as $recenzent)
								<option value="{{ $recenzent->id }}">{{ $recenzent->name }}</option>
								@endforeach
								</select>
							</div>
						</div>
						<div class="panel-footer">
							<button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> Dodaj recenzenta</button>
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
