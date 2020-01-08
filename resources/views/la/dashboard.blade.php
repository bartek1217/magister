@extends('la.layouts.app')
@if(Entrust::hasRole("ADMINISTRATOR") || Entrust::hasRole("SUPER_ADMIN"))
@section('htmlheader_title') @endsection
@section('contentheader_title') Statystyki @endsection
@section('contentheader_description') Instytut Informatyki Uniwersytetu Pedagogicznego w Krakowie @endsection
 @endif
@if(Entrust::hasRole("PRACOWNIK") || Entrust::hasRole("STUDENT"))
@section('htmlheader_title') @endsection
@section('contentheader_title') Witaj w aplikacji do zarządzania pracami dyplomowymi w Instytucie Informatyki Uniwersytetu Pedagogicznego w Krakowie @endsection
@section('contentheader_description')  @endsection
 @endif
@section('main-content')
<!-- Main content -->
@if(Entrust::hasRole("ADMINISTRATOR") || Entrust::hasRole("SUPER_ADMIN"))
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <p>Prace licencjackie</p>
          </div>
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{ $count_licencjats }}</h3>
                  <p>Ilość tematów</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ url('/admin/licencjats') }}" class="small-box-footer">Więcej informacji <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{ $count_reservation_licencjats }} </h3>
                  <p>Ilość zarezerwowanych tematów</p>
                </div>
                <div class="icon">
                   <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ url('/admin/licencjats') }}" class="small-box-footer">Więcej informacji <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div>
          <div class="row">
            <table class="table table-hover">
							<thead>
								<tr>
								<th scope="col">Promotor</th>
								<th scope="col">Ilość tematów</th>
								<th scope="col">Ilość zarezerwowanych tematów</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($licencjats as $licencjat)
								<tr>
								<th scope="row"> {{ $licencjat->name }} </th>
								<td>{{ $licencjat->count }}</td>
								<td>{{ $licencjat->reservation_count }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
          </div>
          <div class="row">
          <p>Prace magisterskie</p>
          </div>
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{ $count_magisters }} </h3>
                  <p>Ilość tematów</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ url('/admin/magisters') }}" class="small-box-footer">Więcej informacji <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{ $count_reservation_magisters }} </h3>
                  <p>Ilość zarezerwowanych tematów</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ url('/admin/magisters') }}" class="small-box-footer">Więcej informacji <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
          </div><!-- /.row -->
          <div class="row">
            <table class="table table-hover">
							<thead>
								<tr>
								<th scope="col">Promotor</th>
								<th scope="col">Ilość tematów</th>
								<th scope="col">Ilość zarezerwowanych tematów</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($magisters as $magister)
								<tr>
								<th scope="row"> {{ $magister->name }} </th>
								<td>{{ $magister->count }}</td>
								<td>{{ $magister->reservation_count }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
          </div>
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->

            </section><!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">



            </section><!-- right col -->
          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
        @endif
@endsection

@push('styles')
<!-- Morris chart -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/morris/morris.css') }}">
<!-- jvectormap -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/datepicker/datepicker3.css') }}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/daterangepicker/daterangepicker-bs3.css') }}">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{ asset('la-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endpush


@push('scripts')
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset('la-assets/plugins/morris/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('la-assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('la-assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('la-assets/plugins/knob/jquery.knob.js') }}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset('la-assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('la-assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('la-assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('la-assets/plugins/fastclick/fastclick.js') }}"></script>
<!-- dashboard -->
<script src="{{ asset('la-assets/js/pages/dashboard.js') }}"></script>
@endpush

