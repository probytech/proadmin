<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="robots" content="noindex, nofollow" />

<link rel="shortcut icon" href="/vendor/proadmin/images/favicon.png" type="image/x-icon">

<script src="/vendor/proadmin/js/vue.js"></script>
<script src="/vendor/proadmin/js/vue-router.js"></script>

<script src="/vendor/proadmin/vue-select/dist/vue-select.js"></script>
<link rel="stylesheet" href="/vendor/proadmin/vue-select/dist/vue-select.css">

<script src="/vendor/proadmin/js/jquery.js"></script>  <!-- for crutch purpose only -->
<script src="/vendor/proadmin/js/script.js"></script>

<link rel="stylesheet" href="/vendor/proadmin/css/jquery.ui.css" />
<script src="/vendor/proadmin/js/jquery.ui.js"></script>

<link rel="stylesheet" href="/vendor/proadmin/css/jquery.datetimepicker.min.css" />
<script src="/vendor/proadmin/js/jquery.datetimepicker.full.min.js"></script>

<script src="/vendor/proadmin/js/ckeditor-MyCustomUploadAdapterPlugin.js"></script>
<script src="/vendor/proadmin/ckeditor/ckeditor.js"></script>
<script src="/vendor/proadmin/js/ckeditor-vue.js"></script>

<!-- Preconnect to external domains for faster loading -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<!-- DNS prefetch for better performance -->
<link rel="dns-prefetch" href="//fonts.googleapis.com">
<link rel="dns-prefetch" href="//fonts.gstatic.com">

<link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">

<link href="{{ \Probytech\Proadmin\Helpers\ViteHelper::css() }}" rel="stylesheet">

<title>{{ __('PRO Admin panel') }}</title>
