<?php

namespace Probytech\Proadmin\Generators\Models\Relations;

use Illuminate\Support\Str;

class BelongsToMany implements Relation
{
    protected $table;
    protected $field;

    public function __construct($table, $field)
    {
        $this->table = $table;
        $this->field = $field;
    }

    public function body()
    {
        $body = "public function ".$this->name()."() \n";

        $body .= "\t{\n";

        $body .= "\t\t";

        $body .= 'return $this->belongsToMany(';

        $body .= $this->relatedClassName().'::class, ';

        $body .= "'".$this->table()."', ";

        $body .= "'".$this->foreignPivotKey()."', ";

        $body .= "'".$this->relatedPivotKey()."'";

        $body .= ");\n";

        $body .= "\t}";

        return $body;
    }

    public function name()
    {
        return Str::camel(Str::plural($this->field->relationship_table_name));
    }

    public function uses()
    {
        return 'use '.$this->relatedNamespace().'\\'.$this->relatedClassName().';';
    }

    protected function relatedClassName()
    {
        return Str::studly(Str::singular($this->field->relationship_table_name));
    }

    protected function relatedNamespace()
    {
        return 'App\Models';
    }

    protected function table()
    {
        return $this->table.'_'.$this->field->relationship_table_name;
    }

    protected function foreignPivotKey()
    {
        return $this->table.'_id';
    }

    protected function relatedPivotKey()
    {
        return $this->field->relationship_table_name.'_id';
    }

    public function returnType()
    {
        return \Illuminate\Database\Eloquent\Relations\BelongsToMany::class;
    }
}
