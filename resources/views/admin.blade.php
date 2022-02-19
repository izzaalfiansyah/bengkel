@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/') }}front/css/bootstrap.min.css">
	<link href="{{ asset('/') }}back/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.css">
    <style>
        .foto-produk { height: 200px; width: 100%; object-fit: cover; transition: 1s; } @media (max-width: 760px) { .foto-produk { height: 190px; } }
        .fc-day-today { background: lightblue !important; }
    </style>
@endsection

@section('js')
    <script src="{{ asset('/') }}front/js/popper.min.js"></script>
    <script src="{{ asset('/') }}front/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.js"></script>
    <script src="https://cdnjs.com/libraries/Chart.js"></script>
    <script src="{{ asset('/') }}asset/admin.js"></script>
	<script src="{{ asset('/') }}back/js/app.js"></script>
@endsection