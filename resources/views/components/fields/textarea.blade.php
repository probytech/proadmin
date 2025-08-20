<script type="text/x-template" id="template-field-textarea">
	<div class="w-full">

		<div class="flex items-center gap-2 mb-1">
			<label class="text-base font-bold" v-text="field.title"></label>

			<div class="text-sm text-grey" v-if="field.remark">
				i
				<div class="text-base" v-text="field.remark"></div>
			</div>
		</div>

		<div class="w-full">
			<textarea v-on:input="change" :rows="textarea_height" class="w-full min-h-16 text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" v-model="value" maxlength="6500"></textarea>
			<div class="text-red-600 text-sm" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-textarea',{
		template: '#template-field-textarea',
		props: ['field', 'pointer'],
		mixins: [recursiveFieldMixin],
		components: {},
		data() {
			return {
				error: '',
				textarea_height: 1,
			}
		},
		methods: {
			check() {

				if (this.field.required != 'optional' && !this.value) {
					this.error = '{{ __('This field is required') }}'
				} else if (this.field.required == 'required_once') {
					// TODO
				}

				if (this.value.length > 6500)
					this.error = '{{ __('More than maxlength (6500 symbols)') }}'

				if (this.error == '')
					return true
				return false
			},
			change(e) {

				let count = (this.value.match(/\n/g) || []).length

				this.textarea_height = count + 1

				if (this.field.db_title == 'title') {
					this.$root.$emit('title_changed', e.target.value)
				}
			},
		},
	})
</script>
