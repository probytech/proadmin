<?php

namespace Probytech\Proadmin\Imports;

use Probytech\Proadmin\Facades\Collection;
use Probytech\Proadmin\Facades\Lang;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

HeadingRowFormatter::default('none');

class Import implements OnEachRow, WithHeadingRow
{
    protected $table;
    protected $realTable;
    protected $collection;
    protected $singles;

    public function __construct($table)
    {
        $this->collection = Collection::get()->where('table_name', $table)->first();

        $this->table = $table;
        $this->realTable = $this->collection->multilanguage ? $table.'_'.Lang::get() : $table;

        $this->singles = $this->getSingleRelations();
    }

    public function onRow(Row $row)
    {
        $row = array_map('strval', $row->toArray());

        $toUpdate = [];

        foreach (Lang::getLangs() as $lang) {
            $toUpdate[$lang->tag] = [];
        }

        $headingLangs = $this->getLangByHeading();
        $headingFields = $this->getDbTitleByHeading();
        $headingFieldTypes = $this->getFieldTypesByHeading();

        foreach (array_keys($row) as $rowKey) {

            if ($rowKey == 'ID' || is_numeric($rowKey)) {
                continue;
            }

            $headingLang = $headingLangs[$rowKey];
            $headingField = $headingFields[$rowKey];
            $headingFieldType = $headingFieldTypes[$rowKey];

            $value = $row[$rowKey];

            if (in_array($headingField, array_keys($this->singles))) {

                if (!isset($this->singles[$headingField][$value])) {
                    $value = 0;
                } else {
                    $value = $this->singles[$headingField][$value]->id;
                }
            }

            if (($headingFieldType == 'checkbox' || $headingFieldType == 'number') && empty($value)) {
                $value = 0;
            }

            if (str_starts_with($value, '=IFERROR(')) {
                $lastCommaPos = strrpos($value, ',');
                if ($lastCommaPos !== false) {
                    $value = trim(substr($value, $lastCommaPos + 1, -1), '"');
                }
            }

            if (!empty($headingLang)) {

                $toUpdate[$headingLang][$headingField] = $value;

            } else {

                foreach (Lang::getLangs() as $lang) {

                    $toUpdate[$lang->tag][$headingField] = $value;
                }
            }
        }

        foreach ($toUpdate as $langTag => $toUpdateItem) {

            if (!$row['ID']) {
                continue;
            }

            $table = $this->collection->multilanguage ? $this->table.'_'.$langTag : $this->table;

            DB::table($table)->updateOrInsert([
                'id' => $row['ID'],
            ], $toUpdateItem);
        }
    }

    protected function getLangByHeading()
    {
        $headings = [];

        foreach (json_decode($this->collection->fields) as $field) {

            if ($field->type == 'password') {
                continue;
            }

            if ($field->type != 'relationship') {

                if ($field->lang) {

                    foreach (Lang::getLangs() as $lang) {
                        $headings[$field->title.' '.Str::upper($lang->tag)] = $lang->tag;
                    }

                } else {

                    $headings[$field->title] = '';
                }

            } else {

                if ($field->relationship_count == 'single') {
                    $headings[$field->title] = '';
                }
            }
        }

        return $headings;
    }

    protected function getDbTitleByHeading()
    {
        $headings = [];

        foreach (json_decode($this->collection->fields) as $field) {

            if ($field->type == 'password') {
                continue;
            }

            if ($field->type != 'relationship') {

                if ($field->lang) {

                    foreach (Lang::getLangs() as $lang) {
                        $headings[$field->title.' '.Str::upper($lang->tag)] = $field->db_title;
                    }

                } else {

                    $headings[$field->title] = $field->db_title;
                }

            } else {

                if ($field->relationship_count == 'single') {
                    $headings[$field->title] = $field->relationship_table_name.'_id';
                }
            }
        }

        return $headings;
    }

    protected function getFieldTypesByHeading()
    {
        $types = [];

        foreach (json_decode($this->collection->fields) as $field) {

            if ($field->lang) {

                foreach (Lang::getLangs() as $lang) {
                    $types[$field->title.' '.Str::upper($lang->tag)] = $field->type;
                }

            } else {
                $types[$field->title] = $field->type;
            }
        }

        return $types;
    }

    protected function getSingleRelations()
    {
        $singles = [];

        $collections = Collection::get()->keyBy('table_name');

        foreach (json_decode($this->collection->fields) as $field) {


            if ($field->type == 'relationship') {

                if ($field->relationship_count == 'single') {

                    $relationshipTable = $collections[$field->relationship_table_name]->multilanguage ? $field->relationship_table_name.'_'.Lang::get() : $field->relationship_table_name;

                    $singles[$field->relationship_table_name.'_id'] = DB::table($relationshipTable)
                    ->select('id', $field->relationship_view_field)
                    ->get()->keyBy($field->relationship_view_field);
                }
            }
        }

        return $singles;
    }
}
