@extends('app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/') }}front/css/slick.css">
    <link rel="stylesheet" href="{{ asset('/') }}front/css/LineIcons.css">
    <link rel="stylesheet" href="{{ asset('/') }}front/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}front/css/nice-select.css">
    <link rel="stylesheet" href="{{ asset('/') }}front/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}front/css/default.css">
    <link rel="stylesheet" href="{{ asset('/') }}front/css/style.css">
    <style>
        .img-produk {
            height: 250px; width: 100%; object-fit: cover;
        }

        @media (max-width: 760px) {
            .img-produk {
                height: 200px;
            }
        }
    </style>
@endsection

@section('js')
    <script src="{{ asset('/') }}front/js/popper.min.js"></script>
    <script src="{{ asset('/') }}front/js/bootstrap.min.js"></script>
    <script src="{{ asset('/') }}asset/home.js"></script>
    <script src="{{ asset('/') }}front/js/vendor/modernizr-3.7.1.min.js"></script>
    <script src="{{ asset('/') }}front/js/slick.min.js"></script>
    <script src="{{ asset('/') }}front/js/jquery-vj-accordion-steps.js"></script>
    <script src="{{ asset('/') }}front/js/jquery.form-validator.min.js"></script>
    <script src="{{ asset('/') }}front/js/jquery.nice-select.min.js"></script>
    <script src="{{ asset('/') }}front/js/jquery.formatter.min.js"></script>
    <script src="{{ asset('/') }}front/js/count-up.min.js"></script>
    <script src="{{ asset('/') }}front/js/main.js"></script>
@endsection