@extends('la.layouts.app')

@section('htmlheader_title')
	Szczegóły tematu pracy licencjackiej
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<!--<img class="profile-image" src="{{ asset('la-assets/img/avatar5.png') }}" alt="">-->
					<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">{{ $licencjat->$view_col }}</h4>
					<div class="row stats">
					</div>
					<p class="desc">Szczegóły tematu pracy licencjackiej</p>
				</div>
			</div>
		</div>
		<div class="col-md-3">
		</div>
		<div class="col-md-4">


		</div>
		<div class="col-md-1 actions">
			@la_access("Licencjats", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/licencjats/'.$licencjat->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			
			@la_access("Licencjats", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.licencjats.destroy', $licencjat->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/licencjats') }}" data-toggle="tooltip" data-placement="right" title="Powrót do listy z tematami prac licencjackich"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> Szczegóły</a></li>
		@if(Entrust::hasRole("STUDENT") && $licencjat->stan == '0')
		<li class=""><a role="tab" data-toggle="tab" href="#tab-reservation" data-target="#tab-reservation"><i class="fa fa-clock-o"></i> Zarezerwuj temat</a></li>
		@endif
		@if($licencjat->stan == '1' && ((Entrust::hasRole("PRACOWNIK") && $licencjat->promotor == Auth::user()->id) || Entrust::hasRole("ADMINISTRATOR")))
			<li class=""><a role="tab" data-toggle="tab" href="#tab-confirm-reservation" data-target="#tab-confirm-reservation"><i class="fa fa-check-square-o"></i> Potwierdź rezerwację</a></li>
		@endif
		@if($licencjat->stan != '0'&& ((Entrust::hasRole("STUDENT") && $licencjat->student == Auth::user()->id) || (Entrust::hasRole("PRACOWNIK") && $licencjat->promotor == Auth::user()->id) || Entrust::hasRole("ADMINISTRATOR")))
			<li class=""><a role="tab" data-toggle="tab" href="#tab-delete-reservation" data-target="#tab-delete-reservation"><i class="fa fa-trash-o"></i> Usuń rezerwację</a></li>
		@endif
		@if($licencjat->stan == '0' && ((Entrust::hasRole("PRACOWNIK") && $licencjat->promotor == Auth::user()->id) || Entrust::hasRole("ADMINISTRATOR")))
			<li class=""><a role="tab" data-toggle="tab" href="#tab-add-reservation" data-target="#tab-add-reservation"><i class="fa fa-plus"></i> Przypisz studenta do tematu</a></li>
		@endif
		@if($licencjat->stan == '2' && Entrust::hasRole("PRACOWNIK") && $licencjat->promotor == Auth::user()->id)
			<li class=""><a role="tab" data-toggle="tab" href="#tab-prop-recenzent" data-target="#tab-prop-recenzent"><i class="fa fa-user-plus"></i> Zaproponuj recenzenta</a></li>
		@endif
		@if($licencjat->stan == '2' && Entrust::hasRole("ADMINISTRATOR"))
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

		
	</div>
	</div>
	</div>
</div>
@endsection
