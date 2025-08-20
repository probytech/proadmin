<script type="text/x-template" id="template-field-ckeditor">
	<div class="w-full">

		<div class="flex items-center gap-2 mb-1">
			<label class="text-base font-bold" v-text="field.title"></label>

			<div class="text-sm text-grey" v-if="field.remark">
				i
				<div class="text-base" v-text="field.remark"></div>
			</div>
		</div>

		<div class="w-full">
			<ckeditor :config="editorConfig" :editor="editor" v-model="value"></ckeditor>
			<div class="text-red-600 text-sm" v-text="error"></div>
		</div>
	</div>
</script>
<script>
	Vue.component('template-field-ckeditor', {
		template: '#template-field-ckeditor',
		props: ['field', 'pointer'],
		mixins: [recursiveFieldMixin],
		components: {
			ckeditor: CKEditor.component
		},
		data() {
			return {
				error: '',
				editor: ClassicEditor,
				editorConfig: {
					extraPlugins: [ MyCustomUploadAdapterPlugin ],
					toolbar: {
						items: [
							'heading', '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|', 'fontSize', 'fontColor', 'fontBackgroundColor', '|', 'bulletedList', 'numberedList', 'code', 'blockQuote', '|', 'indent', 'outdent', 'alignment', '|', 'link', 'imageUpload', 'imageTextAlternative', 'insertTable', 'mediaEmbed', 'htmlEmbed', 'undo', 'redo',
						],
						shouldNotGroupWhenFull: true,
					},
					table: {
						contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties' ]
					},
				},
			}
		},
		methods: {
			check() {

				if (!this.value) {

					if (this.field.required != 'optional') {

						this.error = '{{ __('Required field') }}'

					} else if (this.field.required == 'required_once') {

						// TODO

					} else {

						this.value = ''
					}
				}

				if (this.error == '')
					return true
				return false
			},
		},
		created() {
		},
	})
</script>
