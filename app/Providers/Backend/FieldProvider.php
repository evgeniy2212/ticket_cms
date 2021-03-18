<?php

namespace App\Providers\Backend;

use App\Models\Field;
use App\Models\FieldItem;
use App\Models\FieldType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class FieldProvider
{
    /**
     * @var FieldType
     */
    private $fieldType;

    /**
     * @var FieldItem
     */
    private $fieldItem;

    /**
     * @var array
     */
    private $fieldItems;

    /**
     * @var Field
     */
    private $field;

    /**
     * @var Model
     */
    private $model;

    /**
     * @var string
     */
    private $renderedBody;

    /**
     * @param Model $model
     * @param array $field
     *
     * @return array|string
     */
    public function store(Model $model, array $field)
    {
        $fieldValue = Field::create(
            [
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'field_type_id' => $field['field_type_id'],
                'position' => $field['position']
            ]
        );
        $this->field = Field::find($fieldValue->id);


        $this->fieldItems  = $this->field->fieldItems;
        $this->component  = $field['component'];
        unset($field['component']);
        switch ($this->component) {
            case FieldType::COMPONENT_HEADER:
            case FieldType::COMPONENT_HTML:
            case FieldType::COMPONENT_PARAGRAPH:
            case FieldType::COMPONENT_QUOTE:
            case FieldType::COMPONENT_SPOILER:
            case FieldType::COMPONENT_IFRAME:
            case FieldType::COMPONENT_FILE:
            case FieldType::COMPONENT_LIST:
                $this->storeList($field);
                break;
            case FieldType::COMPONENT_SLIDER:
                $this->storeImageBlock($field);
                break;
            case FieldType::COMPONENT_OPINION:
                $this->storeImageBlock($field);
                break;
        }

        return $this->renderedBody = $this->getBody();
    }

    /**
     * @param array $fieldData
     */
    private function defaultFieldStore(array $fieldData)
    {
        if ($this->fieldItems->isNotEmpty()) {
            $this->fieldItems->map(function ($field) {
                // TODO it doesn`t work))
                dd($field);
                $field->translate(App::getLocale())->body = $field['body'];
                $field->save();
            });
        } else {
            $filteredBlockData = $fieldData;
            unset($filteredBlockData['field_items']);
            if(array_key_exists('body', $filteredBlockData)) {
                $this->fieldItem = FieldItem::create(
                    [
                        'name' => '',
                        'field_id' => $this->field->id,
                        App::getLocale() => [
                            'body' => array_key_exists('body', $filteredBlockData)
                                ? $fieldData['body']
                                : null
                        ]
                    ]
                );
            }
        }
    }

    /**
     * @param array $field
     */
    private function storeList(array $field)
    {
        $list = [];
        foreach ($field['field_items'] as $fieldItem) {
//            $data = [
//                'id'   => $this->fieldItem,
//                'body' => $fieldItem['name'],
//            ];
//            dd($fieldItem['body']);
//            Log::info('fieldItem: ', [$this->fieldItem]);
//            if ($this->fieldItem) {
//                $this->fieldItem->update($data);
//            } else {
                $list[] = FieldItem::create(
                    [
                        'name' => '',
                        'field_id' => $this->field->id,
                        App::getLocale() => [
                            'body' => $fieldItem['body']
                        ]
                    ]
                );
//            }
        }
//        Log::info('List: ', [$list]);
//        Log::info('FieldItems: ', [$field['field_items']]);
        $this->fieldItems = $list;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    private function getBody(): string
    {
//        dd($this->field, $this->component, $this->fieldItem);
//        dd($this->fieldItems);
//dd($this->fieldItems, $this->field, $this->fieldItem);
        return $this->field->visible ? view(
            'backend.field_types.' . $this->component,
            [
                'field'     => $this->field,
                'fieldItems' => $this->fieldItems,
                'fieldItem' => $this->fieldItem,
//                'filter'    => $this->filter,
//                'seoService'=> $this->seoService
            ]
        )->render() : '';
    }
}
