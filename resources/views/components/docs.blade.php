<template id="template-docs">
	<div class="flex flex-col lg:flex-row">
		<div class="flex flex-col gap-5">
			<div v-for="(endpointGroup, index) in docs" class="flex flex-col gap-2">
				<a :href="'#' + index" class="text-xl font-bold" v-text="index"></a>
				<a :href="'#' + endpoint.method + '-' + endpoint.endpoint" v-for="endpoint in endpointGroup" class="text-base flex items-center gap-2">
					<span v-text="endpoint.method" class="w-28" :class="{
						'text-blue-400' : endpoint.method == 'GET',
						'text-green-400' : endpoint.method == 'POST',
						'text-yellow-400' : endpoint.method == 'PUT',
						'text-red-400' : endpoint.method == 'DELETE',
						}"
					></span>
					<span v-text="endpoint.endpoint"></span>
				</a>
			</div>
		</div>
		<div class="lg:pl-10 lg:ml-10 lg:border-l lg:border-stroke lg:flex-1 mt-10 lg:mt-0">
			<h1 class="text-2xl font-bold mb-5">API {{ __('Docs') }}</h1>
			<div v-for="(endpointGroup, index) in docs" class="flex flex-col w-full" :id="index">
				<h1 class="text-xl font-bold mb-2" v-text="index"></h1>
                <div class="flex flex-col gap-10 w-full">
                    <div :id="endpoint.method + '-' + endpoint.endpoint" v-for="endpoint in endpointGroup" class="flex flex-col gap-2 pb-5 border-b border-stroke w-full">
                        <div class="flex items-center gap-2 text-base">
                            <span v-text="endpoint.method" class="w-28" :class="{
                                'text-blue-400' : endpoint.method == 'GET',
                                'text-green-400' : endpoint.method == 'POST',
                                'text-yellow-400' : endpoint.method == 'PUT',
                                'text-red-400' : endpoint.method == 'DELETE',
                                }"
                            ></span>
                            <span v-text="endpoint.endpoint"></span>
                        </div>
                        <div class="text-lg text-grey mb-5" v-text="endpoint.description"></div>
                        <div class="mb-5">
                            <div class="text-lg uppercase text-grey mb-2">REQUEST SCHEMA</div>
                            <div class="text-base">application/json</div>
                        </div>
                        <div class="mb-5" v-if="(endpoint.method == 'GET' && endpoint.endpoint.indexOf('{id}') !== -1) || endpoint.method == 'PUT'">
                            <div class="text-lg uppercase text-grey mb-2">PATH PARAMETERS</div>
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center justify-between text-base">
                                    <div>
                                        <div class="text-lg font-bold text-primary">
                                            ¬ id
                                        </div>
                                        <div class="text-red-400 text-base pl-4">required</div>
                                    </div>
                                    <div class="text-base text-grey">
                                        String
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2" v-if="endpoint.method == 'GET' || endpoint.method == 'POST' || endpoint.method == 'PUT'">
                            <div class="text-lg uppercase text-grey mb-2" v-if="endpoint.method == 'GET'">QUERY PARAMETERS</div>
                            <div class="text-lg uppercase text-grey mb-2" v-else-if="endpoint.method == 'POST' || endpoint.method == 'PUT'">REQUEST BODY PARAMETERS</div>
                            <div class="flex flex-col gap-2 border-l border-primary">
                                <div class="flex items-center justify-between text-base border-b border-stroke pb-2" v-for="field in endpoint.fields">
                                    <div>
                                        <div class="text-lg font-bold text-primary">
                                            ¬ <span v-text="field.title"></span>
                                        </div>
                                        <div class="text-red-400 text-base pl-4" v-text="field.required == 'required' ? 'required' : 'optional'"></div>
                                    </div>
                                    <div class="text-base text-grey">
                                        <span v-text="field.type"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</template>

<script>
	Vue.component('template-docs', {
		template: '#template-docs',
		props: [],
		data() {
			return {
				docs: []
			}
		},
		methods: {
		},
		created: async function() {

			const response = await req.post('/admin/get-docs', {}, false, true, false)

			this.docs = response.data.docs
		}
	})
</script>
