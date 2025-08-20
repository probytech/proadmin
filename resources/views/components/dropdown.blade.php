<script type="text/x-template" id="template-dropdown">
    <div>
        <h1 class="text-xl font-bold mb-5">{{ __('Edit dropdowns') }}</h1>

        <div class="bg-white rounded-xl p-5 py-8 px-10 mb-5">

            <div class="hidden lg:grid grid-cols-12 gap-2 px-5 mb-4">
                <div class="col-span-1 text-grey font-bold text-sm">ID</div>
                <div class="col-span-3 text-grey font-bold text-sm">Title</div>
                <div class="col-span-3 text-grey font-bold text-sm">Priority</div>
                <div class="col-span-4 text-grey font-bold text-sm">Icon</div>
                <div class="col-span-1 text-grey font-bold text-sm"></div>
            </div>

            <div class="flex flex-col gap-3">
                <div class="grid grid-cols-12 gap-2 border border-stroke rounded-sm py-2 px-5" v-for="(elm, index) in dropdown">
                    <div class="col-span-1 flex items-center">
                        <div class="text-sm" v-text="elm.id"></div>
                    </div>
                    <div class="col-span-11 lg:col-span-3">
                        <input v-model="elm.title" type="text" class="w-full border border-stroke rounded-sm px-4 py-2 text-sm xl:text-base ring-0 focus:ring-0 outline-0 focus:outline-none" placeholder="{{ __('Title') }}">
                    </div>
                    <div class="col-span-2 lg:col-span-3">
                        <input v-model="elm.sort" type="text" class="w-full border border-stroke rounded-sm px-4 py-2 text-sm xl:text-base ring-0 focus:ring-0 outline-0 focus:outline-none" placeholder="{{ __('Priority') }}">
                    </div>
                    <div class="col-span-9 lg:col-span-4 flex items-center gap-2">
                        <input class="w-full border border-stroke rounded-sm px-4 py-2 text-sm xl:text-base ring-0 focus:ring-0 outline-0 focus:outline-none" type="text" v-model="elm.icon">
                        <div class="flex items-center gap-2">
                            <img :src="elm.icon" alt="" class="w-6 h-6 shrink-0">
                            <div class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300" v-on:click="add_photo(index)">{{ __('Add') }}</div>
                        </div>
                    </div>
                    <div class="col-span-1 flex items-center justify-center">
                        <div v-on:click="rm(index)" class="shrink-0 w-6 h-6 bg-red-600 hover:bg-red-700 duration-300 cursor-pointer rounded-sm flex items-center justify-center">
                            <svg class="w-2 h-2" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.88111 4.00014L7.8722 1.00892C7.95447 0.926576 7.99987 0.816722 8 0.699584C8 0.58238 7.9546 0.472397 7.8722 0.390185L7.61008 0.128137C7.52767 0.0456 7.41782 0.000396729 7.30055 0.000396729C7.18348 0.000396729 7.07363 0.0456 6.99122 0.128137L4.00013 3.11916L1.00891 0.128137C0.926634 0.0456 0.816715 0.000396729 0.699512 0.000396729C0.582439 0.000396729 0.47252 0.0456 0.390244 0.128137L0.128 0.390185C-0.0426667 0.560852 -0.0426667 0.838445 0.128 1.00892L3.11915 4.00014L0.128 6.99123C0.0456585 7.0737 0.000325203 7.18355 0.000325203 7.30069C0.000325203 7.41783 0.0456585 7.52768 0.128 7.61009L0.390179 7.87214C0.472455 7.95461 0.582439 7.99988 0.699447 7.99988C0.81665 7.99988 0.926569 7.95461 1.00885 7.87214L4.00006 4.88105L6.99115 7.87214C7.07356 7.95461 7.18341 7.99988 7.30049 7.99988H7.30062C7.41776 7.99988 7.52761 7.95461 7.61002 7.87214L7.87213 7.61009C7.95441 7.52775 7.9998 7.41783 7.9998 7.30069C7.9998 7.18355 7.95441 7.0737 7.87213 6.99129L4.88111 4.00014Z" fill="white"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <button v-on:click="add" type="button" class="mt-4 border border-primary text-primary bg-light-grey hover:text-white w-full text-sm font-bold px-4 py-4 rounded-lg cursor-pointer hover:bg-hover duration-300">{{ __('Add dropdown') }} +</button>
        </div>

        <button v-on:click="update()" class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300">{{ __('Save') }}</button>
    </div>
</script>

<script>
	Vue.component('template-dropdown',{
		template: '#template-dropdown',
		data: function () {
			return {
				dropdown: [],
			}
		},
		methods: {
			add: function(){
				var id = 1
				if (this.dropdown.length > 0) {
					id = this.dropdown[this.dropdown.length - 1].id + 1
				}
				this.dropdown.push({
					id: id,
					title: '',
					sort: 0,
					icon: '',
				})
			},
			rm: function(index) {
				this.dropdown.splice(index, 1)
			},
			update: function(){
				request('/admin/update-dropdown', {
					dropdown: this.dropdown,
				}, (data)=>{
					location.reload()
				})
			},

			dragenter: function(e){
				e.preventDefault()
				e.stopPropagation()
			},
			dragleave: function(e){
				e.preventDefault()
				e.stopPropagation()
			},
			dragover: function(e){
				e.preventDefault()
				e.stopPropagation()
			},
			drop: async function(e){
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

							this.menu_item_edit.icon = '/' + obj.url

						} else {

							alert('Error')
						}

					} else {
						alert('File have to be image')
					}
				}
			},
			check: function(){

				if (!this.menu_item_edit.icon)
					this.menu_item_edit.icon = ''

				return true
			},
			add_photo: function(index){

				window.open('/admin/laravel-filemanager?type=admin', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(/^.*\/\/[^\/]+/, '')

						this.dropdown[index].icon = decodeURIComponent(url)
						break;
					}
				};


			},
		},
		watch: {
		},
		created: function(){
			request('/admin/db-select', {
				table: 'dropdown',
				limit: 0,
			}, (data)=>{
				this.dropdown = data.instances
			})
		},
		beforeDestroy: function(){
		},
	})
</script>
