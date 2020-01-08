<!DOCTYPE html>
<html>
    <head>
        <title>Strona nie znaleziona.</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:200,400" rel="stylesheet" type="text/css">
		<link href="{{ asset('la-assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 200;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 60px;
                margin-bottom: 40px;
				color: #444;
            }
			a {
				font-weight:normal;
				color:#3061B6;
				text-decoration: none;
			}
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
				<i class="fa fa-search" style="font-size:120px;color:#FF5959;margin-bottom:30px;"></i>
                @if(isset($record_name) && isset($record_id))
					<div class="title">{{ $record_name }} z id {{ $record_id }} nie znaleziony</div>
				@else
					<div class="title">Strona nie znaleziona</div>
				@endif
				
				@if(Auth::guest())
					<a href="{{ url('/') }}">Strona główna</a> | 
					<a href="javascript:history.back()">Powrót do poprzedniej strony</a>
				@else
					<a href="{{ url(config('laraadmin.adminRoute')) }}">Strona główna</a> | 
					<a href="javascript:history.back()">Powrót do poprzedniej strony</a>
				@endif
            </div>
        </div>
    </body>
</html>
