<script type="text/x-template" id="template-field-photo">
	<div class="w-full" v-on:dragenter="dragenter" v-on:dragleave="dragleave" v-on:dragover="dragover" v-on:drop="drop">

		<div class="flex items-center gap-2 mb-1">
			<label class="text-base font-bold" v-text="field.title"></label>

			<div class="text-sm text-grey" v-if="field.remark">
				i
				<div class="text-base" v-text="field.remark"></div>
			</div>
		</div>

		<div class="w-full">
			<div class="flex items-center gap-2 mb-2">
			    <input class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" type="text" :id="field.db_title" v-model="value" v-on:change="error = ''">
				<div class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300" v-on:click="add_photo(field.db_title)">{{ __('Add') }}</div>
			</div>
            <img :src="value" alt="" class="w-32 rounded-sm bg-background padding-2">
			<div class="text-red-600 text-sm" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-photo',{
		template: '#template-field-photo',
		props: ['field', 'pointer'],
		mixins: [recursiveFieldMixin],
		components: {},
		data() {
			return {
				error: '',
			}
		},
		methods: {
			dragenter(e) {
				e.preventDefault()
				e.stopPropagation()
			},
			dragleave(e) {
				e.preventDefault()
				e.stopPropagation()
			},
			dragover(e) {
				e.preventDefault()
				e.stopPropagation()
			},
			async drop(e){
				e.preventDefault()
				e.stopPropagation()

				if (e.buttons == 0 && e.dataTransfer.items.length > 0) {

					const img = e.dataTransfer.items[0]

					if (img.type.match(/image.*/)) {

						const image_file = img.getAsFile()

						const response = await post('/admin/upload-image', {
							upload: image_file,
						}, true)

						const obj = JSON.parse(response.data)

						if (obj.url) {

							this.value = '/' + obj.url

						} else {

							alert('Error')
						}

					} else {
						alert('File have to be image')
					}
				}
			},
			check() {

				if (this.field.required != 'optional' && !this.file.value) {
					this.error = 'This field is required'
				} else if (this.field.required == 'required_once') {
					// TODO
				}

				if (!this.value)
					this.value = ''

				return true
			},
			add_photo(id) {

				window.open('/admin/laravel-filemanager?type=image', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(/^.*\/\/[^\/]+/, '')

						this.value = decodeURIComponent(url)

						break;
					}
				};
			},
		},
	})
</script>
