<template id="template-collections">
	<div>
		<h1 class="text-xl font-bold mb-5">{{__('Create or edit CRUD collection')}}</h1>
		<div class="bg-white rounded-xl p-5 py-8 px-10 mb-5 flex flex-col gap-3">
			<div>
				<label class="block text-base font-medium mb-1">{{__('Collection')}}</label>
				<div class="w-full relative">
					<select v-on:change="set_menu_item" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none">
							<option :value="-1">{{__('New')}}</option>
							<option :value="index" v-for="(item, index) in menu" v-if="item.type == 'multiple'" v-text="item.title"></option>
					</select>
					<div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
						<svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                            <clipPath id="clip0_755_2893">
                            <rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
                            </clipPath>
                        </svg>
					</div>
				</div>
			</div>
			<div>
				<label class="block text-base font-medium mb-1">{{__('CRUD name')}}</label>
				<div class="w-full relative">
					<input v-model="menu_item_edit.table_name" class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" placeholder="ex. books or products (used to generate DB table)" type="text" :disabled="action != 'create'">
				</div>
			</div>
			<div>
				<label class="block text-base font-medium mb-1">{{__('CRUD title')}}</label>
				<div class="w-full relative">
					<input v-model="menu_item_edit.title" class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" placeholder="Menu title (used for menu item)" type="text">
				</div>
			</div>
			<div>
				<label class="block text-base font-medium mb-1">{{__('Soft delete')}}</label>
				<div class="w-full relative">
					<div class="w-full relative">
						<select v-model="menu_item_edit.is_soft_delete" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none">
							<option value="0">{{__('No')}}</option>
							<option value="1">{{__('Yes')}}</option>
						</select>
						<div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
							<svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
								<clipPath id="clip0_755_2893">
								<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
								</clipPath>
							</svg>
						</div>
					</div>
				</div>
			</div>
			<div>
				<label class="block text-base font-medium mb-1">{{__('Is dev')}}</label>
				<div class="w-full relative">
					<div class="w-full relative">
						<select v-model="menu_item_edit.is_dev" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none">
							<option value="0">{{__('No')}}</option>
							<option value="1">{{__('Yes')}}</option>
						</select>
						<div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
							<svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
								<clipPath id="clip0_755_2893">
								<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
								</clipPath>
							</svg>
						</div>
					</div>

				</div>
			</div>
			<div>
				<label class="block text-base font-medium mb-1">{{__('Multilanguage')}}</label>
				<div class="w-full relative">
					<div class="w-full relative">
						<select v-model="menu_item_edit.multilanguage" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none">
							<option :value="0">{{__('No')}}</option>
							<option :value="1">{{__('Yes')}}</option>
						</select>
						<div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
							<svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
								<clipPath id="clip0_755_2893">
								<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
								</clipPath>
							</svg>
						</div>
					</div>

				</div>
			</div>
			<div>
				<label class="block text-base font-medium mb-1">{{__('Sort')}}</label>
				<div class="w-full relative">
					<input v-model="menu_item_edit.sort" class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" placeholder="0" type="text">
				</div>
			</div>
			<div>
				<label class="block text-base font-medium mb-1">{{__('Dropdown')}}</label>
				<div class="w-full relative">
					<div class="w-full relative">
						<select v-model="menu_item_edit.dropdown_id" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none">
							<option value="0">{{__('None')}}</option>
							<option :value="elm.id" v-for="elm in dropdown" v-text="elm.title"></option>
						</select>
						<div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
							<svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
								<clipPath id="clip0_755_2893">
								<rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
								</clipPath>
							</svg>
						</div>
					</div>
				</div>
			</div>

            <div>
				<label class="block text-base font-medium mb-1">{{ __('Icon') }}</label>
				<div class="flex items-center gap-2">
					<input class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" type="text" v-model="menu_item_edit.icon">
					<div class="flex items-center gap-2">
						<img :src="menu_item_edit.icon" alt="" class="w-6 h-6 shrink-0">
						<div class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300" v-on:click="addPhoto()">{{ __('Add') }}</div>
					</div>
				</div>
			</div>
		</div>

		<h2 class="text-xl font-bold mb-3">{{__('Edit fields')}}</h2>
		<div class="bg-white rounded-xl p-5 py-8 px-10 mb-5">

            <div class="grid grid-cols-18 gap-2 w-full mb-2">
                <div class="col-span-1 text-grey font-bold text-sm">{{__('Visible?')}}</div>
                <div class="col-span-3 text-grey font-bold text-sm">{{__('Lang')}}</div>
                <div class="col-span-2 text-grey font-bold text-sm">{{__('Show in list')}}</div>
                <div class="col-span-3 text-grey font-bold text-sm">{{__('Field type')}}</div>
                <div class="col-span-3 text-grey font-bold text-sm">{{__('Field DB name')}}</div>
                <div class="col-span-3 text-grey font-bold text-sm">{{__('Field visual name')}}</div>
                <div class="col-span-2"></div>
                <div class="col-span-1"></div>
            </div>

            <div class="flex flex-col gap-2">
                <div class="grid grid-cols-18 gap-2 w-full" v-for="(field, index) in menu_item_edit.fields">
                    <div class="col-span-1">
                        <div class="flex items-center mt-2">
                            <input name="remember" v-model="field.is_visible" id="remember" type="checkbox" class="hidden peer">
                            <label for="remember" class="cursor-pointer peer-checked:[&_svg]:scale-100 text-xs md:text-sm [&_svg]:scale-0 peer-checked:[&_.custom-checkbox]:border-primary peer-checked:[&_.custom-checkbox]:bg-primary select-none flex items-center space-x-2">
                                <span class="flex items-center justify-center w-6 h-6 border border-stroke rounded custom-checkbox duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </span>
                            </label>
                        </div>
                    </div>

                    <div class="col-span-3">
                        <div class="w-full relative">
                            <select v-model="field.lang" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" v-on:change="blockChange">
                                <option value="1">{{__('Separate')}}</option>
                                <option value="0">{{__('Common')}}</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
                                <svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-2">
                        <div class="w-full relative">
                            <select v-model="field.show_in_list" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" v-on:change="blockChange">
                                <option value="no">{{__('No')}}</option>
                                <option value="yes">{{__('Yes')}}</option>
                                <option value="editable">{{__('Editable')}}</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
                                <svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <div class="w-full relative">
                            <select v-model="field.type" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" v-on:change="blockChange">
                                <option value="text">Text</option>
                                <option value="textarea">Long text</option>
                                <option value="ckeditor">Ckeditor</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="color">Color picker</option>
                                <option value="date">Date picker</option>
                                <option value="datetime">Date and time picker</option>
                                <option value="relationship">Relationship</option>
                                <option value="file">File</option>
                                <option value="photo">Photo</option>
                                <option value="gallery">Gallery</option>
                                <option value="password">Password (hashed)</option>
                                <option value="money">Money</option>
                                <option value="number">Number</option>
                                <option value="enum">Select (ENUM)</option>
                                <option value="repeat">Repeat (unaviable)</option>
                                <option value="translater">Translater (deprecated)</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
                                <svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <div class="w-full">
                            <input v-if="field.type != 'relationship' && field.type != 'enum'" v-model="field.db_title" type="text" class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" placeholder="Название">
                            <div v-else-if="field.type == 'relationship'" class="w-full">
                                <div class="w-full relative">

                                    <select v-model="field.relationship_count" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" title="One to many require Single relation on other table">
                                        <option value="single">Single</option>
                                        <option value="many">Many</option>
                                        <option value="editable">One to many</option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
                                        <svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                                            <clipPath id="clip0_755_2893">
                                            <rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
                                            </clipPath>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-full relative mt-1">
                                    <select v-model="field.relationship_table_name" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none">
                                        <option :value="item.table_name" v-for="(item, index) in menu" v-text="item.title"></option>
                                    </select>
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
                                        <svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                                            <clipPath id="clip0_755_2893">
                                            <rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
                                            </clipPath>
                                        </svg>
                                    </div>
                                </div>
                                <div v-if="field.relationship_table_name && field.relationship_count != 'editable'">
                                    <div class="w-full relative mt-1">
                                        <select v-model="field.relationship_view_field" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none">
                                            <option :value="item.db_title" v-for="(item, index) in get_fields_by_table_name(field.relationship_table_name)" v-text="item.title"></option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
                                            <svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                                                <clipPath id="clip0_755_2893">
                                                <rect width="10" height="10" fill="white" transform="translate(10) rotate(90)"/>
                                                </clipPath>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else-if="field.type == 'enum'">
                                <input v-model="field.db_title" type="text" class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" placeholder="Field DB name">
                                <input v-for="(item, index) in field.enum" v-model="field.enum[index]" type="text" class="mt-1 w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" placeholder="Element">
                                <div class="flex items-center gap-2 mt-1">
                                    <button class="w-1/2 bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300" v-on:click="add_enum(field.enum)">Add</button>
                                    <button class="w-1/2 bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-red-500 duration-300" v-on:click="remove_enum(field.enum)">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <input v-model="field.title" type="text" class="w-full text-base px-4 py-2 appearance-none border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none" placeholder="Название">
                    </div>
                    <div class="col-span-2">
                        <div class="w-full relative">
                            <select v-model="field.required" class="w-full text-base px-4 py-2 appearance-none cursor-pointer border border-stroke rounded-sm ring-0 focus:ring-0 outline-0 focus:outline-none">
                                <option value="optional">Optional</option>
                                <option value="required">Required</option>
                                <option value="required_unique">Required unique</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center bg-background rounded-sm w-6 h-6">
                                <svg class="w-2 h-2" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.27438 7.5809L9.89199 2.96329C10.0396 2.81042 10.0354 2.56683 9.88252 2.41919C9.73339 2.27516 9.49699 2.27516 9.34789 2.41919L5.00233 6.76474L0.656779 2.41919C0.506526 2.26896 0.262929 2.26896 0.112677 2.41919C-0.0375528 2.56947 -0.0375528 2.81304 0.112677 2.96329L4.73028 7.5809C4.88056 7.73113 5.12413 7.73113 5.27438 7.5809Z" fill="#171219"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="flex items-center gap-2 mt-2">
                            <div v-on:click="up_menu_item(index)" class="w-6 h-6 shrink-0 flex items-center justify-center bg-blue-400 text-white text-sm font-bold rounded-lg cursor-pointer hover:bg-blue-500 duration-300">
                                <svg class="w-2 h-2" width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.45962 0.54038C5.20578 0.28654 4.79422 0.28654 4.54038 0.54038L0.403806 4.67696C0.149965 4.9308 0.149965 5.34235 0.403806 5.59619C0.657647 5.85003 1.0692 5.85003 1.32304 5.59619L5 1.91924L8.67696 5.59619C8.9308 5.85003 9.34235 5.85003 9.59619 5.59619C9.85003 5.34235 9.85003 4.9308 9.59619 4.67696L5.45962 0.54038ZM5.65 9L5.65 1L4.35 1L4.35 9L5.65 9Z" fill="#171219"/>
                                </svg>
                            </div>
                            <div v-on:click="remove_menu_item(index)" class="w-6 h-6 shrink-0 flex items-center justify-center bg-red-600 text-white text-sm font-bold rounded-lg cursor-pointer hover:bg-red-500 duration-300">
                                <svg class="w-2 h-2" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.88111 4.00011L7.8722 1.00889C7.95447 0.926545 7.99987 0.816691 8 0.699553C8 0.58235 7.9546 0.472366 7.8722 0.390155L7.61008 0.128106C7.52767 0.0455695 7.41782 0.000366211 7.30055 0.000366211C7.18348 0.000366211 7.07363 0.0455695 6.99122 0.128106L4.00013 3.11913L1.00891 0.128106C0.926634 0.0455695 0.816715 0.000366211 0.699512 0.000366211C0.582439 0.000366211 0.47252 0.0455695 0.390244 0.128106L0.128 0.390155C-0.0426667 0.560821 -0.0426667 0.838415 0.128 1.00889L3.11915 4.00011L0.128 6.9912C0.0456585 7.07367 0.000325203 7.18352 0.000325203 7.30066C0.000325203 7.4178 0.0456585 7.52765 0.128 7.61006L0.390179 7.87211C0.472455 7.95458 0.582439 7.99985 0.699447 7.99985C0.81665 7.99985 0.926569 7.95458 1.00885 7.87211L4.00006 4.88102L6.99115 7.87211C7.07356 7.95458 7.18341 7.99985 7.30049 7.99985H7.30062C7.41776 7.99985 7.52761 7.95458 7.61002 7.87211L7.87213 7.61006C7.95441 7.52772 7.9998 7.4178 7.9998 7.30066C7.9998 7.18352 7.95441 7.07367 7.87213 6.99126L4.88111 4.00011Z" fill="white"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

			<button v-on:click="add_menu_item()" type="button" id="addField" class="mt-4 border border-primary text-primary bg-light-grey hover:text-white w-full text-sm font-bold px-4 py-4 rounded-lg cursor-pointer hover:bg-hover duration-300">+ Add one more field</button>

		</div>


		<div class="form-group">
			<div class="col-md-12">
				<button v-if="action == 'create'" v-on:click="create_crud()" class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300">Create CRUD</button>
				<div v-else class="sides">
					<button v-on:click="update_crud()" class="bg-primary text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-hover duration-300">Update CRUD</button>
					<button v-on:click="remove_crud()" class="bg-red-600 text-white text-sm font-bold px-4 py-2 rounded-lg cursor-pointer hover:bg-red-500 duration-300">Remove CRUD</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	Vue.component('template-collections',{
		template: '#template-collections',
		data: function () {
			return {
				menu: [],
				action: 'create',
				to_remove: [],
				template: {
					table_name: '',
					title: '',
					is_soft_delete: 0,
					is_dev: 0,
					multilanguage: 1,
					sort: 10,
					fields: [],
					dropdown_id: 0,
					icon: '',
				},
				menu_item_edit: {
					table_name: '',
					title: '',
					is_soft_delete: 0,
					is_dev: 0,
					multilanguage: 1,
					sort: 10,
					fields: [],
					dropdown_id: 0,
					icon: '',
				},
				dropdown: [],
			}
		},
		methods: {
			set_menu_item: function(e){
				var id = e.target.value

				if (id == -1) {
					this.menu_item_edit = Object.assign({}, this.template)
					this.action = 'create'
				} else {
					this.menu_item_edit = this.menu[id]
					this.to_remove = []
					this.action = 'edit'
				}

			},
			remove_menu_item: function(index) {
				this.to_remove.push(this.menu_item_edit.fields[index].id)
				this.menu_item_edit.fields.splice(index, 1)
			},
			up_menu_item: function(index) {
				if (index > 0) {
					var temp = this.menu_item_edit.fields[index]
					this.menu_item_edit.fields[index] = this.menu_item_edit.fields[index - 1]
					this.menu_item_edit.fields[index - 1] = temp
					this.$forceUpdate()
				}
			},
			add_menu_item: function(){

				var id = 0
				if (this.menu_item_edit.fields.length > 0) {
					for (var i = 0; i < this.menu_item_edit.fields.length; i++) {
						if (this.menu_item_edit.fields[i].id > id)
							id = this.menu_item_edit.fields[i].id
					}
					id++
				}

				this.menu_item_edit.fields.push({id: id, required: 'optional', is_visible: true, lang: 1, show_in_list: 'no'})
			},
			async create_crud() {

				const response = await req.post('/admin/db-create-table', {
					table_name: this.menu_item_edit.table_name,
					title: this.menu_item_edit.title,
					is_soft_delete: this.menu_item_edit.is_soft_delete,
					is_dev: this.menu_item_edit.is_dev,
					multilanguage: this.menu_item_edit.multilanguage,
					sort: this.menu_item_edit.sort,
					dropdown_id: this.menu_item_edit.dropdown_id,
					fields: this.menu_item_edit.fields,
					icon: this.menu_item_edit.icon
				})

				if (response.success) {
					location.reload();
				} else {
					alert(response.data.message);
				}
			},
			async update_crud() {

				const response = await req.post('/admin/db-update-table', {
					id: this.menu_item_edit.id,
					table_name: this.menu_item_edit.table_name,
					title: this.menu_item_edit.title,
					is_soft_delete: this.menu_item_edit.is_soft_delete,
					is_dev: this.menu_item_edit.is_dev,
					multilanguage: this.menu_item_edit.multilanguage,
					sort: this.menu_item_edit.sort,
					dropdown_id: this.menu_item_edit.dropdown_id,
					fields: this.menu_item_edit.fields,
					to_remove: this.to_remove,
					icon: this.menu_item_edit.icon
				})

				if (response.success) {
					location.reload();
				} else {
					alert(response.data.message);
				}
			},
			async remove_crud() {

				if (confirm("Are you sure?")) {

					const response = await req.post('/admin/db-remove-table', {
						table_name: this.menu_item_edit.table_name,
					})

					if (response.success) {
						location.reload()
					} else {
						alert(response.data.message)
					}
				}
			},
			get_fields_by_table_name: function(table_name){

				var fields = []

				this.menu.forEach((elm)=>{
					if (elm.table_name == table_name) {
						fields = elm.fields
						return
					}
				})

				return fields
			},
			add_enum: function(select){
				select.push('')
				this.$forceUpdate()
			},
			remove_enum: function(select){
				select.splice(-1,1)
				this.$forceUpdate()
			},
			fix_ids: function(){
				for (var j = 0; j < this.menu_item_edit.fields.length; j++) {
					this.menu_item_edit.fields[j].id = j
				}
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
			addPhoto: function(){

				window.open('/admin/laravel-filemanager?type=admin', 'FileManager', 'width=900,height=600');
				window.SetUrl = (items)=>{

					for (var i = 0; i < items.length; i++) {

						var url = items[i].url.replace(/^.*\/\/[^\/]+/, '')

						this.menu_item_edit.icon = decodeURIComponent(url)
						break;
					}
				};

			},
		},
		watch: {
			'menu_item_edit.fields': function(fields){
				fields.forEach((field)=>{
					if (field.type == 'enum' && field.enum == undefined) {
						field.enum = []
					} else if (field.type != 'enum' && field.enum != undefined) {
						delete field.enum;
					}
				})
			}
		},
		created: function(){
			if (app) {
				this.menu = app.menu
			} else {
				this.$root.$on('menu_init',(menu)=>{
					this.menu = menu
				})
			}
			request('/admin/db-select', {
				table: 'dropdown',
				limit: 0,
			}, (data)=>{
				this.dropdown = data.instances
			})
		},
		beforeDestroy: function(){
			this.$root.$off('menu_init')
		},
	})
</script>
