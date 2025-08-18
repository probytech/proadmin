<?php

namespace App\Proadmin\Services;

use Illuminate\Support\Collection;

class CollectionService
{
    protected Collection $menu;

	public function __construct()
	{
        $jsonMenu = json_decode(file_get_contents(storage_path('collections.json')), true) ?? [];

        $menu = [];

        foreach ($jsonMenu as $item) {
            $item['fields'] = json_encode($item['fields']);
            $menu[] = new CollectionItem($item);
        }

        $this->menu = collect($menu);
	}

    public function create($data)
    {
        $data['id'] = $this->menu->max('id') + 1;

        $this->menu->push(new CollectionItem($data));

        $this->save();
    }

    public function get()
	{
        return $this->menu;
	}

    public function update($table, $data)
    {
        $itemIndex = $this->menu->search(function ($item) use ($table) {
            return $item->table_name === $table;
        });

        if ($itemIndex !== false) {
            $currentItem = $this->menu[$itemIndex];

            foreach ($data as $key => $value) {
                if (property_exists($currentItem, $key)) {
                    $currentItem->$key = $value;
                }
            }

            $this->save();
        }
    }

    public function delete($table)
    {
        $this->menu = $this->menu->where('table_name', '!=', $table);

        $this->save();
    }

    public function getTitlesMenuByTable($table)
	{
        $menu = $this->menu->where('table_name', $table)->first();

        $fields = json_decode($menu->fields);

        $fields_titles = [];
        foreach ($fields as $field) {

            if (isset($field->db_title))
                $fields_titles[$field->db_title] = $field->title;
            else
                $fields_titles[$field->relationship_table_name] = $field->title;
        }

        return [
            'fields_titles' => $fields_titles,
            'menu_title'    => $menu->title,
        ];
    }

    // TODO: Remove json_encode and json_decode
    protected function save()
    {
        $menu = $this->menu->toArray();

        foreach ($menu as &$item) {
            $item->fields = json_decode($item->fields);
        }

        file_put_contents(storage_path('collections.json'), json_encode($this->menu->toArray(), JSON_PRETTY_PRINT));
    }
}
