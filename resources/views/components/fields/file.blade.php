<script type="text/x-template" id="template-field-file">
	<div class="w-full">

		<div class="flex items-center gap-2 mb-1">
			<label class="text-base font-bold" v-text="field.title"></label>

			<div class="text-sm text-grey" v-if="field.remark">
				i
				<div class="text-base" v-text="field.remark"></div>
			</div>
		</div>

		<div class="w-full">
            <div class="flex items-center gap-2">
                <input class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" type="text" :id="field.db_title" v-model="value" v-on:change="error = ''">
                <div class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300" v-on:click="add_file(field.db_title)">{{ __('Add') }}</div>
            </div>
			<div class="text-red-600 text-sm" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-file',{
		template: '#template-field-file',
		props: ['field', 'pointer'],
		mixins: [recursiveFieldMixin],
		components: {},
		data() {
			return {
				error: '',
			}
		},
		methods: {
			check() {

				if (this.field.required != 'optional' && !this.file.value) {
					this.error = '{{ __('Required field') }}'
				} else if (this.field.required == 'required_once') {
					// TODO
				}

				if (!this.value)
					this.value = ''

				return true
			},
			add_file(id) {

				window.open('/admin/laravel-filemanager?type=file', 'FileManager', 'width=900,height=600');
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
