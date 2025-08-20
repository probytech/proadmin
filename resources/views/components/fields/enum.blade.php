<script type="text/x-template" id="template-field-enum">
	<div class="w-full">

		<div class="flex items-center gap-2 mb-1">
			<label class="text-base font-bold" v-text="field.title"></label>

			<div class="text-sm text-grey" v-if="field.remark">
				i
				<div class="text-base" v-text="field.remark"></div>
			</div>
		</div>

		<div class="w-full">
            <div class="w-full relative">
                <select class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" v-model="value">
                    <option :value="field.enum[index]" v-for="(item, index) in field.enum" v-text="field.enum[index]"></option>
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
                    <svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                    </svg>
                </div>
            </div>
			<div class="text-red-600 text-sm" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-enum', {
		template: '#template-field-enum',
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

				return true
			},
		},
		mounted() {
			if (!this.value && this.field.enum.length > 0) {
				this.value = this.field.enum[0]
			}
		},
	})
</script>
