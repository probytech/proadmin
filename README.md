<p align="center">
  <a href="https://probytech.com.ua">
    <img src="https://probytech.com.ua/images/og.jpg" width="318px" alt="Probytech logo" />
  </a>
</p>

<h3 align="center">Open-source ProAdmin CMS</h3>
<p align="center">The open-source headless CMS made with Laravel and Vue.js, flexible and fully customizable.</p>

<br />

<p align="center">
  <a href="https://packagist.org/packages/probytech/proadmin"><img src="https://img.shields.io/packagist/v/probytech/proadmin" alt="Latest Stable Version"></a>
</p>

<br>

ProAdmin is a free and open-source headless CMS enabling you to manage any content, anywhere.

- **Modern Admin Pane**: Elegant, entirely customizable and a fully extensible admin panel.
- **Customizable**: You can quickly build your logic by fully customizing APIs, routes, or plugins to fit your needs perfectly.
- **Blazing Fast and Robust**: Built on top of Laravel and Vue.js, ProAdmin delivers reliable and solid performance.
- **Front-end Agnostic**: Use any front-end framework (React, Next.js, Vue, Angular, etc.), mobile apps or even IoT.

## Getting Started

### ⏳ Installation

Install Laravel first


```bash
composer create-project laravel/laravel="12.*" PROJECT_NAME
cd PROJECT_NAME
```

- (Use composer to install the ProAdmin project)

```bash
composer require probytech/proadmin
```

- Configure DB and APP_URL file in .env

- Run install command

```bash
php artisan proadmin:install
```

- Add class aliases in bottom of file config/app.php
```bash
'Image' => Intervention\Image\Facades\Image::class,
```

- Publish the packages config and assets
```bash
php artisan vendor:publish --tag=lfm_config 
php artisan vendor:publish --tag=lfm_public
```

- Run commands to clear cache
```bash
php artisan route:clear
php artisan config:clear
```

- In "config/lfm.php"
```bash
// in any place
add line: 'middlewares' => ['admin'],

change line: ('disk' => 'public',) to ('disk' => 'lfm',)

//add category of folder
in folder_categories (48 line)

'admin' => [
    'folder_name'  => 'vendor/proadmin/icons',
    'startup_view' => 'list',
    'max_size'     => 50000, // size in KB
    'valid_mime'   => [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif',
        'image/svg+xml',
        'application/pdf',
        'text/plain',
    ],
],
```

- Add disk "config/filesystems.php"
```bash
// add like line 44 from:
'lfm' => [
    'driver' => 'local',
    'root' => public_path(),
    'url' => env('APP_URL'),
    'visibility' => 'public',
],
```


Enjoy 🎉

# Concept

- You can generate CRUDs with this package. The package also automatically creates model files with relations and migrations (they are also added when updating or deleting CRUDs).
- Data about dropdown list and CRUDs (menu) are stored in table `menu`.
- You have the ability to create “single” entities to manage static content.
- The admin panel is fully multi-lingual. CRUD multilingualism is represented as identical tables in different languages, e.g. post_en, post_de. This approach [denormalizes](https://en.wikipedia.org/wiki/Denormalization) the database (increasing the amount of space occupied), but makes a very simple approach to manage it. The multilanguage model is very simple and is represented by the MultilanguageModel class. 
- Additionaly you can use Translatable trait to translate your content. So you can create non multilanguage instance with common fields like title_en, title_de and than add it in your model to protected array $translatable = ['title'].
- The admin panel is written without using npm or other such technologies, allowing it to be edited without reassembling.

# Usage of CRUD generator

- Go to https://yourdomain.com/admin/menu
- Fill the fields:
  - **CRUD name** - the table name for the DB
  - **CRUD title** - the title for the menu
  - **Is dev** - the option to hide CRUD from menu (see more [Open dev menu](#open-dev-menu))
  - **Multilanguage** - the option to enable multilanguage (see more [Multilanguage](multilanguage))
  - **Sort** - sort order in the menu
  - **Dropdown** - set parent menu item (see more [Dropdown menu](dropdown-menu))
  - **Icon** - set icon for the menu
  - **Fields** - set of fields that appear in your CRUD (15 types of the fields)
- Press the button "Create"
- Now you can create Controller and use generated Model in it. Or you can go to /api/{crud_slug}

Notes:
- All the data about CRUDs is stored in `menu` table 
- If you want to move the generated model from the default folder - you need to edit the **Model field** in the model in `menu` table properly.
- If you **DON'T** want to edit the model automatically when you change the CRUD - you just need to remove the **Model field** in the `menu` table (but this will break /api/{model}/{id}).

You can see the examples below:

- Creation:

![crudEditImage](https://probytech.com.ua/storage/photos/1/proadmin/menu.png)

- List:

![crudListImage](https://probytech.com.ua/storage/photos/1/proadmin/index.png)

- Edit:

![crudEntityImage](https://probytech.com.ua/storage/photos/1/proadmin/edit.png)

# Usage of Static content generator

- Go to https://yourdomain.com/admin/single
- Fill the fields:
  - **Single title** - title for the menu
  - **Single name** - inner ID for the API and usage in the code
  - **Sort** - sort order
  - **Dropdown** - parent menu item (see more [Dropdown menu](#dropdown-menu))
  - **Icon** - icon for the menu
  - **Fields** - set of fields that appear in your Single (15 types of the fields)
- Press the button "Create"
- Now you can use it in the code like that: 
```php
use Single;

Single::get('your_single_api_id_here');
```

You can see the examples below:

- Creation:

![singleCreateImage](https://probytech.com.ua/storage/photos/1/proadmin/single_create.png)

- Edit:

![singleEditImage](https://probytech.com.ua/storage/photos/1/proadmin/single.png)

# Dropdown menu

You can add a parent menu item for the singles and CRUDs you create.

- Go to: https://yourdomain.com/admin/dropdown

- Add dropdowns

- Go to CRUD or single (static content generator) and add parent

You can see the example of the dropdown below:

![imageDropdown](https://probytech.com.ua/storage/photos/1/proadmin/dropdown.png)

# Multilanguage

- The admin panel is fully multi-lingual. CRUD multilingualism is represented as identical tables in different languages, e.g. post_en, post_de. This approach [denormalizes](https://en.wikipedia.org/wiki/Denormalization) the database (increasing the amount of space occupied), but makes a very simple approach to manage it. The multilanguage model is very simple and is represented by the MultilanguageModel class. 

- To make the custom model multilingual - just inherit the App\Proadmin\Models\MultilanguageModel class.

- There is "Multilanguage" select in CRUD to make it multilangual.

- Each field has a Lang column to make it multi-lingual. If Lang == “common”, then when saving the field - the value will be updated in all the tables (for example posts_en, posts_de, posts_fr). If Lang == “separate”, then when saving the field - the value will be updated in the current language table only (for example posts_en).

- You can edit languages at https://yourdomain.com/admin/settings.

- The language of the admin panel is represented in the “admin_lang_tag” column of the User.

- Additionaly you can use Translatable trait to translate your content. So you can create non multilanguage instance with common fields like title_en, title_de and than add it in your model to protected array $translatable = ['title'].

- There is a class Lang. It has several useful methods:

```
use Lang;

Lang::all(); // get all languages
Lang::get(); // get current language tag
Lang::main(); // get main language tag
...
```

# How to

## Open dev menu

- By default, internal settings for languages, crud, single and dropdown are hidden.

- All hidden menu items are displayed if PROADMIN_DEV=true in the .env file.

- You can also hide CRUDs ("Is dev" option).

- To show hidden menu items, you need to add "?dev=" to your address, for example: https://yourdomain.com/admin?dev=.

## Add custom page

- Create Vue component. For example: 

```
/views/proadmin/components/custom/custom.blade.php
```

And that's it! Your component will be automatically available in the admin panel.
