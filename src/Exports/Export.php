<?php

namespace Probytech\Proadmin\Exports;

use Probytech\Proadmin\Facades\Collection;
use Probytech\Proadmin\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Export implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $collections;
    protected $collection;
    protected $table;

    public function __construct($table)
    {
        $this->collections = Collection::get()->keyBy('table_name');
        $this->collection = Collection::get()->where('table_name', $table)->first();
        $this->table = $this->collection->multilanguage ? $table.'_'.Lang::get() : $table;
    }

    public function query()
    {
        $toSelect = [$this->table.'.id'];
        $joins = [];

        foreach (json_decode($this->collection->fields) as $field) {

            if ($field->type == 'password') {
                continue;
            }

            if ($field->type != 'relationship') {

                if ($field->lang) {
                    foreach (Lang::getLangs() as $lang) {
                        $toSelect[] = $this->table.'.'.$field->db_title.' AS '.$field->db_title.'_'.$lang->tag;
                    }
                } else {
                    $toSelect[] = $this->table.'.'.$field->db_title;
                }
            } else {

                if ($field->relationship_count == 'single') {

                    $relationshipTable = $this->collections[$field->relationship_table_name]->multilanguage ? $field->relationship_table_name.'_'.Lang::get() : $field->relationship_table_name;

                    if ($relationshipTable == $this->table) {
                        $relationshipTableOther = $relationshipTable.'_other';
                    } else {
                        $relationshipTableOther = $relationshipTable;
                    }

                    $toSelect[] = $relationshipTableOther.'.'.$field->relationship_view_field.' AS '.$field->relationship_table_name.'_'.$field->relationship_view_field;

                    $joins[] = [$relationshipTable.' as '.$relationshipTableOther, $relationshipTableOther.'.id', $this->table.'.'.$field->relationship_table_name.'_id'];
                }
            }
        }

        return DB::table($this->table)
        ->select($toSelect)
        ->when($this->collection->multilanguage, function($q) {
            foreach (Lang::getLangs() as $lang) {
                if ($lang->tag != Lang::get()) {
                    $q->join($this->table, $this->table.'.id', $this->table.'.id');
                }
            }
        })
        ->when(!empty($joins), function($q) use ($joins) {
            foreach ($joins as $join) {
                $q->leftJoin($join[0], $join[1], $join[2]);
            }
        })
        ->orderBy('id', 'ASC');
    }

    public function headings() : array
    {
        $headings = ['ID'];

        foreach (json_decode($this->collection->fields) as $field) {

            if ($field->type == 'password') {
                continue;
            }

            if ($field->type != 'relationship') {

                if ($field->lang) {
                    foreach (Lang::getLangs() as $lang) {
                        $headings[] = $field->title.' '.Str::upper($lang->tag);
                    }
                } else {
                    $headings[] = $field->title;
                }
            } else {
                if ($field->relationship_count == 'single') {
                    $headings[] = $field->title;
                }
            }
        }

        return $headings;
    }

    public function map($item) : array
    {
        $map = [$item->id];

        foreach (json_decode($this->collection->fields) as $field) {

            if ($field->type == 'password') {
                continue;
            }

            if ($field->type != 'relationship') {

                if ($field->lang) {

                    foreach (Lang::getLangs() as $lang) {

                        $dbTitle = $field->db_title.'_'.$lang->tag;
                        $map[] = $item->$dbTitle;
                    }

                } else {

                    $dbTitle = $field->db_title;
                    $map[] = $item->$dbTitle;
                }

            } else {

                if ($field->relationship_count == 'single') {

                    $dbTitle = $field->relationship_table_name.'_'.$field->relationship_view_field;
                    $map[] = $item->$dbTitle;
                }
            }
        }

        return $map;
    }
}
