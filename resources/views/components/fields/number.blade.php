<script type="text/x-template" id="template-field-number">
	<div class="w-full">

		<div class="flex items-center gap-2 mb-1">
			<label class="text-base font-bold" v-text="field.title"></label>

			<div class="text-sm text-grey" v-if="field.remark">
				i
				<div class="text-base" v-text="field.remark"></div>
			</div>
		</div>

		<div class="w-full">
			<input class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" type="text" v-model="value" v-on:change="error = ''">
			<div class="text-red-600 text-sm" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-number',{
		template: '#template-field-number',
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

				if (!$.isNumeric(this.value))
					this.error = '{{ __('Numeric field') }}'

				if (this.error == '')
					return true
				return false
			},
		},
		computed: {
			default() {
				return 0
			},
		},
	})
</script>
