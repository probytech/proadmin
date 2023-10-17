<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex" />

<link href="/vendor/proadmin/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<script src="/vendor/proadmin/js/vue.js"></script>
<script src="/vendor/proadmin/js/vue-router.js"></script>

<script src="/vendor/proadmin/vue-select/dist/vue-select.js"></script>
<link rel="stylesheet" href="/vendor/proadmin/vue-select/dist/vue-select.css">

<script src="/vendor/proadmin/js/jquery.js"></script>  <!-- for crutch purpose only -->
<script src="/vendor/proadmin/js/script.js"></script>

<link rel="stylesheet" href="/vendor/proadmin/css/spectrum.css" />
<script src="/vendor/proadmin/js/spectrum.js"></script>

<link rel="stylesheet" href="/vendor/proadmin/css/jquery.ui.css" />
<script src="/vendor/proadmin/js/jquery.ui.js"></script>

<link rel="stylesheet" href="/vendor/proadmin/css/jquery.datetimepicker.min.css" />
<script src="/vendor/proadmin/js/jquery.datetimepicker.full.min.js"></script>

<script src="/vendor/proadmin/js/ckeditor-MyCustomUploadAdapterPlugin.js"></script>
<script src="/vendor/proadmin/ckeditor/ckeditor.js"></script>
<script src="/vendor/proadmin/js/ckeditor-vue.js"></script>

@if (Platform::mobile())
	<link rel="stylesheet" href="<?php include 'vendor/proadmin/css/converter-mobile.php' ?>">
	<link rel="stylesheet" href="/vendor/proadmin/css/ckeditor-mobile.css" />
@else
	<link rel="stylesheet" href="<?php include 'vendor/proadmin/css/converter-desktop.php' ?>">
	<link rel="stylesheet" href="/vendor/proadmin/css/ckeditor.css" />
@endif

<title>{{ __('proadmin.admin_panel') }}</title>