<?php

namespace Probytech\Proadmin\Models\Translator;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class TranslatorBuilder extends Builder
{
    public function get($columns = ['*'])
    {
        $this->makeFieldsLanguagable();

        $models = parent::get($columns);

        if (Request::method() == 'GET') {

            foreach ($models as $model) {

                $model->removeLanguagesFromFields();
            }
        }

        return $models;
    }

    public function makeFieldsLanguagable()
    {
        if ($this->query->columns) {

            foreach ($this->query->columns as &$column) {

                $column = $this->model->tr($column);
            }
        }

        if ($this->query->orders) {

            foreach ($this->query->orders as &$order) {

                if (isset($order['column'])) {
                    $order['column'] = $this->model->tr($order['column']);
                }
            }
        }

        if ($this->query->wheres) {

            foreach ($this->query->wheres as &$where) {

                if (isset($where['column'])) {

                    $where['column'] = $this->model->tr($where['column']);
                }
            }
        }
    }
}
