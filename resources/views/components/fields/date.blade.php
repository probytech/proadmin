<script type="text/x-template" id="template-field-date">
	<div class="w-full">

		<div class="flex items-center gap-2 mb-1">
			<label class="text-base font-bold" v-text="field.title"></label>

			<div class="text-sm text-grey" v-if="field.remark">
				i
				<div class="text-base" v-text="field.remark"></div>
			</div>
		</div>

		<div class="w-full">
			<input class="datepicker w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" data-init="0" type="text" :id="id" v-on:change="error = ''">
			<div class="text-red-600 text-sm" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-date', {
		template: '#template-field-date',
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

				if (!this.value)
					this.value = '2000-01-01'
				return true
			},
		},
		computed: {
			id() {

				if (this.field.db_title) {

					return this.field.db_title
				}

				if (this.pointer) {

					return 'date-' + this.field.id + '-' + this.pointer.join('-')
				}

				return 'date-' + this.field.id
			},
			default() {
				return '2000-01-01'
			},
		},
		mounted() {

			const app = this
			const today = new Date()
			let date = today.getFullYear().toString().padStart(2, '0') + '-' +
				(today.getMonth() + 1).toString().padStart(2, '0') + '-' +
				today.getDate().toString().padStart(2, '0')

			if (this.value)
				date = this.value
			else this.value = date

			if ($('#' + this.id).attr('data-init') == "0") {

				$('#' + this.id).datepicker({
					dateFormat: "yy-mm-dd",
					onSelect(text) {
						app.value = text
					}
				})
				$('#' + this.id).attr('data-init', '1')
			}

			$('#' + this.id).datepicker( "setDate", date )
		},
	})
</script>
