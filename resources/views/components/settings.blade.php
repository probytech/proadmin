<template id="template-settings">
	<div class="flex items-center gap-5">
		<div class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300" v-on:click="addLanguage">{{__('Add language')}}</div>
		<div class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300" v-on:click="removeLanguage">{{__('Delete language')}}</div>
	</div>
</template>

<script>
	Vue.component('template-settings', {
		template: '#template-settings',
		props: [],
		data() {
			return {}
		},
		methods: {
			async removeLanguage() {

				const tag = prompt('Enter language', '')

				if (tag) {

					const response = await req.delete('/admin/api/language/' + tag, {
						blocks: this.blocks,
					})

					document.location.reload()
				}
			},
			async addLanguage() {

				const tag = prompt('Enter language', '')

				if (tag) {

					const response = await req.post('/admin/api/language/' + tag, {
						blocks: this.blocks,
					})

					document.location.reload()
				}
			},
		},
	})
</script>
