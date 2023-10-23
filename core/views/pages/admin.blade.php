@extends('proadmin.layouts.app')

@section('content')

@if(Platform::mobile())
	<div class="topbar">
		<div class="toggle" :class="{ active: show_mobile_menu }" @click="show_mobile_menu = !show_mobile_menu">
			<div class="toggle-item"></div>
			<div class="toggle-item"></div>
			<div class="toggle-item"></div>
		</div>
		<div class="sidebar-header">
			<a href="/" target="_blank">
				<img src="/vendor/proadmin/images/logo.svg" alt="" class="sidebar-logo">
			</a>
            <router-link to="/admin" class="sidebar-header-title">{{ __('proadmin.admin_panel') }}</router-link>
		</div>
	</div>
@endif

<main>
	<template-sidebar :class="{ active: show_mobile_menu }" :is_dev="is_dev" :menu="menu" :dropdown="dropdown"></template-sidebar>
	<div class="content">
		<router-view></router-view>
	</div>
</main>
@endsection

@section('javascript')
<script>
	const languages = JSON.parse('{!! $languages !!}')
	const ckeditor_path = '<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}"; ?>/admin/upload-image'
</script>

@foreach ($custom_components as $custom_component)
	@include($custom_component['path'])
@endforeach

@include('proadmin.mixins.recursive-field')
@include('proadmin.components.dropdown')
@include('proadmin.components.fields.repeat')
@include('proadmin.components.fields.checkbox')
@include('proadmin.components.fields.ckeditor')
@include('proadmin.components.fields.color')
@include('proadmin.components.fields.date')
@include('proadmin.components.fields.datetime')
@include('proadmin.components.fields.enum')
@include('proadmin.components.fields.file')
@include('proadmin.components.fields.gallery')
@include('proadmin.components.fields.money')
@include('proadmin.components.fields.number')
@include('proadmin.components.fields.password')
@include('proadmin.components.fields.photo')
@include('proadmin.components.fields.relationship')
@include('proadmin.components.fields.text')
@include('proadmin.components.fields.textarea')
@include('proadmin.components.single')
@include('proadmin.components.singlefields')
@include('proadmin.components.singlepage')
@include('proadmin.components.settings')
@include('proadmin.components.docs')
@include('proadmin.components.sidebar')
@include('proadmin.components.menu')
@include('proadmin.components.edit')
@include('proadmin.components.main')
@include('proadmin.components.index')
@include('proadmin.components.import')

<script>

	const router = new VueRouter({
		mode: 'history',
		routes: [
			<?php foreach ($custom_components as $custom_component): ?>
			{
				path: '/admin/<?php echo $custom_component['name'] ?>',
				name: '<?php echo $custom_component['name'] ?>',
				component: Vue.options.components['template-<?php echo $custom_component['name'] ?>'],
			},
			<?php endforeach ?>
			{
				path: '/admin/dropdown',
				name: 'dropdown',
				component: Vue.options.components['template-dropdown'],
			}, {
				path: '/admin/menu',
				name: 'menu',
				component: Vue.options.components['template-menu'],
			}, {
				path: '/admin/single',
				name: 'single',
				component: Vue.options.components['template-single'],
			}, {
				path: '/admin/settings',
				name: 'settings',
				component: Vue.options.components['template-settings'],
			}, {
				path: '/admin/docs',
				name: 'docs',
				component: Vue.options.components['template-docs'],
			}, {
				path: '/admin/single/:single_id',
				name: 'singlepage',
				component: Vue.options.components['template-singlepage'],
			}, {
				path: '/admin/:table_name',
				name: 'index',
				component: Vue.options.components['template-index'],
			}, {
				path: '/admin/:table_name/create',
				name: 'create',
				component: Vue.options.components['template-edit'],
			}, {
				path: '/admin/:table_name/edit/:edit_id',
				name: 'edit',
				component: Vue.options.components['template-edit'],
			},  {
				path: '/admin/import/:table_name',
				name: 'import',
				component: Vue.options.components['template-import'],
			}, {
				path: '/admin',
				name: 'main',
				component: Vue.options.components['template-main'],
			},
		],
	})
	
	Vue.component("v-select", VueSelect.VueSelect);

	var app = new Vue({
		router,
		el: '#app',
		data: {
			is_dev: {{ config('app.debug') ? 1 : 0 }},
			menu: [],
			languages: languages,
			dropdown: [],
			show_mobile_menu: false,
		},
		methods: {
			get_language: function(){
				for (i in this.languages) {
					if (this.languages[i].is_active)
						return this.languages[i]
				}
				return null
			},
			set_language: function(lang){

				set_cookie('lang', lang.tag, 30)
				document.location.reload()

				// for (i in this.languages) {
				// 	if (this.languages[i].id == lang.id) {

				// 		this.languages[i].is_active = true
				// 		// this.$root.$emit('set_language', lang)
				// 		set_cookie('lang', lang.tag, 30)

				// 	} else this.languages[i].is_active = false
				// }
				// this.$forceUpdate()
			},
		},
		created: function(){

			var lang_tag = get_cookie('lang')

			if (!lang_tag) {
				for (i in this.languages) {
					if (this.languages[i].main_lang == 1) {

						this.languages[i].is_active = true
						set_cookie('lang', this.languages[i].tag, 30)

					} else this.languages[i].is_active = false
				}
			} else {
				for (i in this.languages) {
					if (this.languages[i].tag == lang_tag) {

						this.languages[i].is_active = true
						set_cookie('lang', this.languages[i].tag, 30)

					} else this.languages[i].is_active = false
				}
			}
			
			request('/admin/get-menu', {}, (data)=>{
				
				this.menu = data.menu
				this.dropdown = data.dropdown

				this.$root.$emit('menu_init', this.menu)
			})
		},
		mounted: function(){

		},
	})
</script>

<script>
	
	$('.sidebar').on('click', function(e) {
        if (this == (e.target)) {
            $(this).removeClass('active')
            $('.toggle').removeClass('active')
        }
    })
	$('.sidebar').on('click', function(e){
		if(e.target.tagName == 'A'){
			$(this).removeClass('active')
			$('.toggle').removeClass('active')
		}
	})
</script>

@endsection