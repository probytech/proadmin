<script type="text/x-template" id="template-import">
	<div class="flex flex-col gap-3 items-start">

        <router-link :to="'/admin/' + menu_item.table_name" class="flex items-center gap-2 bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300">
            <svg class="w-2 h-2" width="9" height="10" viewBox="0 0 9 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.54038 4.54038C0.28654 4.79422 0.28654 5.20578 0.540381 5.45962L4.67696 9.59619C4.9308 9.85004 5.34235 9.85004 5.59619 9.59619C5.85004 9.34235 5.85004 8.9308 5.59619 8.67696L1.91924 5L5.59619 1.32305C5.85003 1.0692 5.85003 0.657647 5.59619 0.403807C5.34235 0.149966 4.9308 0.149966 4.67695 0.403807L0.54038 4.54038ZM9 4.35L1 4.35L1 5.65L9 5.65L9 4.35Z" fill="white"/>
            </svg>
            {{ __('Back') }}
        </router-link>

        <h1 class="text-xl font-bold mb-5" v-text="'{{ __('Import') }} ' + menu_item.title"></h1>

		<div class="bg-white w-full rounded-xl p-5 py-8 px-10 mb-5 flex flex-col items-start gap-3">

			<div class="w-full">
				<label class="block text-base font-medium mb-2">{{ __('File') }}</label>
				<div class="w-full">
					<input
                        type="file"
                        v-on:change="setXlsx"
                        name='xlsx'
                        class="text-sm
                        file:mr-5 file:py-2 file:px-4 file:border
                        file:bg-light-grey file:cursor-pointer hover:file:bg-hover
                        hover:file:text-white file:duration-300 file:rounded-lg"
                    >
				</div>
			</div>

            <button class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300" v-on:click="send">
                {{ __('Import') }}
            </button>
		</div>

	</div>
</script>

<script>
	Vue.component('template-import',{
		template: '#template-import',
		data: function () {
			return {
				menu: [],
				menu_item: {title: ''},
				xlsx: '',
			}
		},
		methods: {
			setXlsx: function(event) {
				this.xlsx = event.target.files[0];
			},
			send: async function() {

				const route = '/admin/import/' + this.menu_item.table_name

				const response = await post(route, {
					xlsx: this.xlsx,
				}, true)

				if (response.success) {
					location.href = '/admin/' + this.menu_item.table_name
				} else {
					if (response.data.error) {
						alert(response.data.error)
					} else {
						alert('Error')
					}
				}
			},
			find_menu_elm: function(){
				for(var i = 0, length = this.menu.length; i < length; i++){
					if (this.menu[i].table_name == this.$route.params.table_name) {
						this.menu_item = this.menu[i]
						break
					}
				}
			},
		},
		computed: {
		},
		watch: {
		},
		created: function(){
			if (app) {
				this.menu = app.menu
				this.find_menu_elm()
			} else {
				this.$root.$on('menu_init',(menu)=>{
					this.menu = menu
					this.find_menu_elm()
				})
			}
		},
		beforeDestroy: function(){
		},
	})
</script>

<style>

	.import_input_row{
		margin: 10px 0 30px;
	}

</style>
