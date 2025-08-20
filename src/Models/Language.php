<?php

namespace Probytech\Proadmin\Models;

use Probytech\Proadmin\Facades\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Language extends Model
{
	public $timestamps = false;

	protected $table = 'languages';

	protected $fillable = [
		'tag',
		'main_lang',
	];

	public static function boot()
	{
		parent::boot();

		static::deleting(function($lang) {

			self::removeTables($lang->tag);

			$field = new SingleField();
			$field->removeTables($lang->tag);
		});

		static::creating(function($lang) {

			$main = Language::select('tag')->where('main_lang', 1)->first();

			self::addTables($lang->tag, $main->tag);

			$field = new SingleField();
			$field->addTables($lang->tag, $main->tag);
		});
	}

    public static function removeTables($tag)
	{
		$collections = Collection::get();

		foreach ($collections as $collection) {

			if ($collection->multilanguage == 1) {

				Schema::dropIfExists("{$collection->table_name}_$tag");
			}
		}
	}

	public static function addTables($tag, $main_tag)
	{
		$collections = Collection::get();

		foreach ($collections as $collection) {

			if ($collection->multilanguage == 1) {

				Schema::dropIfExists("{$collection->table_name}_$tag");
				DB::statement("CREATE TABLE {$collection->table_name}_$tag LIKE {$collection->table_name}_$main_tag");
				DB::statement("INSERT {$collection->table_name}_$tag SELECT * FROM {$collection->table_name}_$main_tag");
			}
		}
	}
}
