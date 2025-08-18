<?php

namespace App\Models\Traits;

use App\Models\Translator\TranslatorBuilder;
use App\Proadmin\Facades\Lang;

trait Translatable
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function tr($column)
    {
        if (in_array($column, $this->translatable)) {

            return $column.'_'.Lang::get();
        }

        return $column;
    }

    public function save(array $options = [])
    {
        $this->setAttributeLanguagable($this->attributes, [Lang::get()]);

        $saved = parent::save($options);

        $this->removeLanguagesFromFields();

        return $saved;
    }

    public function saveAllLangs(array $options = [])
    {
        $this->setAttributeLanguagable($this->attributes, Lang::all());

        $saved = parent::save($options);

        $this->removeLanguagesFromFields();

        return $saved;
    }

    public function create(array $attributes = [])
    {
        $this->setAttributeLanguagable($attributes, Lang::all());

        $model = static::query()->create($attributes);

        $model->removeLanguagesFromFields();

        return $model;
    }

    public function update(array $attributes = [], array $options = [])
    {
        $this->setAttributeLanguagable($attributes, [Lang::get()]);

        parent::update($attributes, $options);

        $this->removeLanguagesFromFields();
    }

    public function newEloquentBuilder($query)
    {
        $builder = new TranslatorBuilder($query);

        return $builder;
    }

    // TODO: make fields natively accessible
    public function removeLanguagesFromFields()
    {
        foreach ($this->translatable as $field) {

            foreach (Lang::all() as $lang) {

                $langField = $field.'_'.$lang;

                if (isset($this->$langField)) {

                    if (Lang::get() == $lang) {

                        $this->$field = $this->$langField;
                    }

                    unset($this->$langField);
                }
            }
        }
    }

    public function scopeTranslatable(TranslatorBuilder $query): void
    {
        $query->makeFieldsLanguagable();
    }

    public function __get($key)
    {
        if (in_array($key, $this->translatable)) {

            $key = $key.'_'.Lang::get();
        }

        return parent::__get($key);
    }

    protected function setAttributeLanguagable(&$attributes, $langs)
    {
        foreach ($attributes as $key => $value) {

            if (in_array($key, $this->translatable)) {

                foreach ($langs as $lang) {

                    $langKey = $key.'_'.$lang;

                    $attributes[$langKey] = $value;
                }

                unset($attributes[$key]);
            }
        }
    }
}
