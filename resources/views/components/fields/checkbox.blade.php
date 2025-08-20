<script type="text/x-template" id="template-field-checkbox">
	<div class="w-full">

		<div class="flex items-center gap-2 mb-1">
			<label class="text-base font-bold" v-text="field.title"></label>

			<div class="text-sm text-grey" v-if="field.remark">
				i
				<div class="text-base" v-text="field.remark"></div>
			</div>
		</div>

		<div class="w-full">
            <div class="flex items-center mb-3">
                <input name="remember" id="remember" type="checkbox" class="hidden peer" v-model="value">
                <label for="remember" class="cursor-pointer peer-checked:[&_svg]:scale-100 text-xs md:text-sm [&_svg]:scale-0 peer-checked:[&_.custom-checkbox]:border-primary peer-checked:[&_.custom-checkbox]:bg-primary select-none flex items-center space-x-2">
                    <span class="flex items-center justify-center w-8 h-8 border border-stroke rounded custom-checkbox duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 text-white duration-300 ease-out">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </span>
                </label>
            </div>
			<div class="text-red-600 text-sm" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-checkbox', {
		template: '#template-field-checkbox',
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
		computed: {
			default() {
				return false
			},
		},
		created() {
		},
	})
</script>
