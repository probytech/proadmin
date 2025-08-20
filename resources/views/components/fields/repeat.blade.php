<template id="template-field-repeat">
	<div class="w-full">
		<div class="flex items-center gap-2 mb-1">
			<label class="text-base font-bold" v-text="field.title"></label>

			<div class="text-sm text-grey" v-if="field.remark">
				i
				<div class="text-base" v-text="field.remark"></div>
			</div>
		</div>
		<div class="flex flex-col gap-2">
			<template v-for="i in length">
				<div class="p-3 bg-white border border-stroke rounded-sm relative">
					<div class="w-6 h-6 bg-red-500 rounded-sm flex items-center justify-center text-white cursor-pointer hover:bg-red-600 duration-300 absolute top-2 right-2" v-on:click="remove(pointer, field.value, i - 1, false)">
						<svg class="w-2 h-2" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.88111 4.00014L7.8722 1.00892C7.95447 0.926576 7.99987 0.816722 8 0.699584C8 0.58238 7.9546 0.472397 7.8722 0.390185L7.61008 0.128137C7.52767 0.0456 7.41782 0.000396729 7.30055 0.000396729C7.18348 0.000396729 7.07363 0.0456 6.99122 0.128137L4.00013 3.11916L1.00891 0.128137C0.926634 0.0456 0.816715 0.000396729 0.699512 0.000396729C0.582439 0.000396729 0.47252 0.0456 0.390244 0.128137L0.128 0.390185C-0.0426667 0.560852 -0.0426667 0.838445 0.128 1.00892L3.11915 4.00014L0.128 6.99123C0.0456585 7.0737 0.000325203 7.18355 0.000325203 7.30069C0.000325203 7.41783 0.0456585 7.52768 0.128 7.61009L0.390179 7.87214C0.472455 7.95461 0.582439 7.99988 0.699447 7.99988C0.81665 7.99988 0.926569 7.95461 1.00885 7.87214L4.00006 4.88105L6.99115 7.87214C7.07356 7.95461 7.18341 7.99988 7.30049 7.99988H7.30062C7.41776 7.99988 7.52761 7.95461 7.61002 7.87214L7.87213 7.61009C7.95441 7.52775 7.9998 7.41783 7.9998 7.30069C7.9998 7.18355 7.95441 7.0737 7.87213 6.99129L4.88111 4.00014Z" fill="white"/>
						</svg>
					</div>
					<component
						:is="'template-field-' + subfield.type"
						:field="subfield"
						:pointer="[...(pointer ?? []), i - 1]"
						:key="subfield.id"
						v-for="subfield in field.value.fields">
					</component>
				</div>
			</template>
			<button class="mt-4 border border-primary text-primary bg-light-grey hover:text-white w-full text-sm font-bold px-4 py-4 rounded-lg cursor-pointer hover:bg-hover duration-300" v-on:click="add">{{ __('Add') }} +</button>
		</div>
	</div>
</template>
<script>
	Vue.component('template-field-repeat', {
		template: '#template-field-repeat',
		props: ['field', 'pointer'],
		mixins: [recursiveFieldMixin],
		components: {},
		data() {
			return {
			}
		},
		methods: {	// TODO: rewrite recursion more readable, especially remove
			remove(pointer, field_value, i, is_remove) {

				for (field of field_value.fields) {

					if (field.type != 'repeat') {

						if (!pointer || is_remove) {

							field.value.splice(i, 1)

						} else {

							let deep = field.value

							for (const pos of pointer) {

								deep = deep[pos]
							}

							deep.splice(i, 1)
						}

					} else {

						// if (!pointer) {

							field.value.length.splice(i, 1)

						// } else {

						// 	let deep = field.value.length

						// 	for (let i = 0; i < pointer.length - 1; i++) {

						// 		const pos = pointer[i]

						// 		deep = deep[pos]
						// 	}

						// 	deep.splice(i, 1)
						// }

						// probably doesnt work on recursion, depth > 2
						this.remove([...(pointer ?? []), i], field.value, i, true)
					}
				}

				if (is_remove) return

				if (!pointer) {

					field_value.length--

				} else {

					let deep = field_value.length

					for (let i = 0; i < pointer.length - 1; i++) {

						const pos = pointer[i]

						deep = deep[pos]
					}

					const last = pointer[pointer.length - 1]

					deep[last]--

					field_value.length = [...field_value.length]	// force update
				}
			},
			add() {

				for (field of this.field.value.fields) {

					if (field.type != 'repeat') {

						if (!this.pointer) {

							field.value.push(null)

						} else {

							field.value = this.add_recursive_value(
								JSON.parse(JSON.stringify(field.value))		// clone to avoid unnecessary mutation ?
							)

							// 	const i1 = this.pointer[0]
							// 	const i2 = this.pointer[1]
							// 	this.field.value.length[i1][i2].push(null)

							// [["elm 1","elm 2"],["elm 1"]]	// one recursion less than above
						}
					}
				}

				if (!this.pointer) {

					this.field.value.length++

				} else {

					this.field.value.length = this.add_recursive_length(
						JSON.parse(JSON.stringify(this.field.value.length))	// clone to avoid unnecessary mutation ?
					)

					// const i1 = this.pointer[0]
					// const i2 = this.pointer[1]
					// this.field.value.length[i1][i2]++

					// [2,1]	// one recursion less than above
				}
			},
			add_recursive_value(value) {

				let deep = value

				for (let i = 0; i < this.pointer.length; i++) {

					const pos = this.pointer[i]

					if (!deep[pos] && i < this.pointer.length - 1) {

						deep[pos] = []

					} else if (!deep[pos]) {

						deep[pos] = [null]

					} else {

						deep[pos].push(null)
					}
				}

				return value
			},
			add_recursive_length(length) {

				if (length == 0)
					length = []

				let deep = length

				for (let i = 0; i < this.pointer.length; i++) {

					const pos = this.pointer[i]

					if (!deep[pos] && i < this.pointer.length - 1) {

						deep[pos] = []

					} else if (!deep[pos]) {

						deep[pos] = 1

					} else {

						deep[pos]++
					}
				}

				return length
			},
		},
		computed: {
			length() {

				if (!this.pointer) {

					return this.field.value.length
				}

				let deep = this.field.value.length

				for (const pos of this.pointer) {

					deep = deep[pos]
				}

				return deep
			},
		},
		created() {
		},
	})
</script>
