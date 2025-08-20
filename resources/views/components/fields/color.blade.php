<script type="text/x-template" id="template-field-color">
	<div class="w-full">
		<div class="flex items-center gap-2 mb-1">
			<label class="text-base font-bold" v-text="field.title"></label>

			<div class="text-sm text-grey" v-if="field.remark">
				i
				<div class="text-base" v-text="field.remark"></div>
			</div>
		</div>

		<div class="w-full flex items-center">
            <input class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" type="text" v-model="value" v-on:change="error = ''" maxlength="191">
			<input class="w-12 h-12 border-none appearance-none" type="color" v-model="value">
		</div>
        <div class="text-red-600 text-sm" v-text="error"></div>
	</div>
</script>
<script>
	Vue.component('template-field-color',{
		template: '#template-field-color',
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

				if (!this.value) {
					this.value = this.default
                }

				return true
			},
		},
		computed: {
			default() {
				return '#000000'
			},
		},
		mounted() {

			if (!this.value) {
				this.value = this.default
            }
		},
	})
</script>
