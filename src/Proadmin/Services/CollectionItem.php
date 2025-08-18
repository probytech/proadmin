<?php

namespace App\Proadmin\Services;

use App\Proadmin\Generators\Models\Relations\BelongsTo;
use App\Proadmin\Generators\Models\Relations\BelongsToMany;
use App\Proadmin\Generators\Models\Relations\HasMany;

class CollectionItem
{
    public $id;
    public $title;
    public $table_name;
    public $fields;
    public $is_dev;
    public $multilanguage;
    public $is_soft_delete;
    public $sort;
    public $dropdown_id;
    public $icon;
    public $model;
    public $type = 'multiple';

	public function __construct($data)
	{
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->table_name = $data['table_name'];
        $this->fields = $data['fields'];
        $this->is_dev = $data['is_dev'];
        $this->multilanguage = $data['multilanguage'];
        $this->is_soft_delete = $data['is_soft_delete'] ?? 0;
        $this->sort = $data['sort'] ?? 0;
        $this->dropdown_id = $data['dropdown_id'] ?? 0;
        $this->icon = $data['icon'] ?? '';
        $this->model = $data['model'] ?? '';
	}


	public function getFields($withDefaults = true)
    {
        $fields = [];

		if ($withDefaults) {
			$fields[] = 'id';
		}

        foreach (json_decode($this->fields) as $field) {

            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {
                    $fields[] = 'id_'.$field->relationship_table_name;
                }

            } else {
                $fields[] = $field->db_title;
            }
        }

		if ($withDefaults) {
			$fields[] = 'created_at';
			$fields[] = 'updated_at';
		}

        return $fields;
    }

    	# TODO: remove DRY
	public function getFieldsType()
    {
        $fields = [];

        foreach (json_decode($this->fields) as $field) {

            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {
                    $fields['id_'.$field->relationship_table_name] = $field->type;
                }

            } else {
                $fields[$field->db_title] = $field->type;
            }
        }

        return $fields;
    }

    	# TODO: remove DRY
	public function getFieldsRequired()
    {
        $fields = [];

        foreach (json_decode($this->fields) as $field) {

			$required = $field->required == 'optional' ? 'nullable' : 'required';

            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {
                    $fields['id_'.$field->relationship_table_name] = $required;
                }

            } else {
                $fields[$field->db_title] = $required;
            }
        }

        return $fields;
    }

	# TODO: remove DRY
	public function getVisibleFields()
    {
        $fields = [];

		foreach (json_decode($this->fields) as $field) {

			if ($field->show_in_list !== 'yes') {
				continue;
			}

            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {
                    $fields[] = 'id_'.$field->relationship_table_name;
                }

            } else {
                $fields[] = $field->db_title;
            }
        }

        return $fields;
    }

	public function getRelations()
	{
		$relations = [];

		foreach (json_decode($this->fields) as $field) {

            if ($field->type != 'relationship') {
                continue;
            }

            if ($field->relationship_count == 'single') {

                $relation = new BelongsTo($field);

            } else if ($field->relationship_count == 'many') {

                $relation = new BelongsToMany($this->table_name, $field);

            } elseif ($field->relationship_count == 'editable') {

                $relation = new HasMany($this->table_name, $field);
            }

            $relations[] = $relation->name();
        }

		return $relations;
	}
}
