<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="title" content="{{ env('APP_NAME') }}">
	<meta name="keywords" conent="Fopegram, Bengkel, Primausadha">
	<meta name="contact" content="{{ env('APP_PHONE') }}">
	<meta name="description" content="Sistem aplikasi manajemen otomisasi service part dan jasa pada bengkel">

	<title><?= env('APP_NAME') ?></title>
	@yield('css')

	<link rel="shorcut icon" href="{{ asset('/') }}favicon.png">
	<link rel="stylesheet" href="{{ asset('/') }}asset/material-icons/material-icons.css">
	<link rel="stylesheet" href="{{ asset('/') }}asset/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="{{ asset('/') }}asset/leaflet/leaflet.css">
    <link rel="stylesheet" href="{{ asset('/') }}front/css/jquery-ui.min.css">

	<style>
		* { scroll-behavior: smooth }
		body { overflow-x: hidden }
		.form-control { margin-bottom: 8px; }
		.material-icons { font-size: 14px; }
		.ui-menu { z-index: 10500 }
	</style>
</head>
<body>
	<div id="app"></div>

    <script src="{{ asset('/') }}front/js/vendor/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('/') }}front/js/jquery-ui.min.js"></script>
	<script src="{{ asset('/') }}asset/sweetalert2/sweetalert2.all.min.js"></script>
	<script src="{{ asset('/') }}asset/leaflet/leaflet.js"></script>
	<script>
		var app_name = '{{ env('APP_NAME') }}';
		var app_whatsapp = '{{ env('WA_NUMBER') }}';
		var app_url = '{{ url('/') }}';
		var app_asset = '{{ asset('/') }}';
		var app_nick = '{{ env('APP_NICK') }}';
		var app_user_id = '{{ Session::get('id') }}';

        window.jQuery = $;

		window.notif = (message, type, error = false) => {
			if (error) {
				const Toast = Swal.mixin({
					toast: true,
					position: 'top-end',
					showConfirmButton: false,
					showCloseButton: true,
					timer: 2000
				});

				return Toast.fire({
					title: message,
					icon: type
				});
			} else {
				return Swal.fire({
					title: type[0].toUpperCase() + type.slice(1),
					text: message,
					icon: type,
					timer: 1500
				});
			}
		}
	</script>
	@yield('js')
</body>
</html>