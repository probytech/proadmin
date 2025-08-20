@extends('proadmin::layouts.app')

@section('content')

<div class="lg:!hidden flex items-center justify-between bg-white py-2 px-4">
    <div class="flex flex-col items-center justify-center w-10 h-10 bg-primary rounded-full" :class="{ active: show_mobile_menu }" @click="show_mobile_menu = !show_mobile_menu">
        <div class="w-4 h-[2px] bg-white rounded-full duration-300" :class="{'-mb-[1px] rotate-45': show_mobile_menu}"></div>
        <div class="w-3 h-[2px] bg-white rounded-full my-1 duration-300" :class="{ 'hidden': show_mobile_menu }"></div>
        <div class="w-4 h-[2px] bg-white rounded-full duration-300" :class="{'-mt-[1px] -rotate-45': show_mobile_menu}"></div>
    </div>
    <div class="flex items-center gap-2">
        <a href="/" target="_blank">
            <img src="/vendor/proadmin/images/logo.svg" alt="" class="w-16">
        </a>
        <router-link to="/admin" class="text-base font-bold bg-background rounded-lg px-4 py-2">{{ __('Admin panel') }}</router-link>
    </div>

</div>

<main class="min-h-screen flex">
	<template-sidebar :class="{ active: show_mobile_menu }" :show_mobile_menu="show_mobile_menu" :is_dev="is_dev" :menu="menu" :dropdown="dropdown"></template-sidebar>
	<div class="flex-1 py-7 px-5 md:px-12">
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

@include('proadmin::mixins.recursive-field')
@include('proadmin::components.dropdown')
@include('proadmin::components.fields.repeat')
@include('proadmin::components.fields.checkbox')
@include('proadmin::components.fields.ckeditor')
@include('proadmin::components.fields.color')
@include('proadmin::components.fields.date')
@include('proadmin::components.fields.datetime')
@include('proadmin::components.fields.enum')
@include('proadmin::components.fields.file')
@include('proadmin::components.fields.gallery')
@include('proadmin::components.fields.money')
@include('proadmin::components.fields.number')
@include('proadmin::components.fields.password')
@include('proadmin::components.fields.photo')
@include('proadmin::components.fields.relationship')
@include('proadmin::components.fields.text')
@include('proadmin::components.fields.textarea')
@include('proadmin::components.single')
@include('proadmin::components.singlefields')
@include('proadmin::components.singlepage')
@include('proadmin::components.settings')
@include('proadmin::components.docs')
@include('proadmin::components.sidebar')
@include('proadmin::components.collections')
@include('proadmin::components.edit')
@include('proadmin::components.index')
@include('proadmin::components.import')

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
				path: '/admin/collections',
				name: 'collections',
				component: Vue.options.components['template-collections'],
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
			is_dev: {{ config('proadmin.is_dev') || isset($_GET['dev']) ? 1 : 0 }},
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

@endsection
