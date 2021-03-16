<?php

namespace App\Providers\Backend;

use App\Models\Field;
use App\Models\FieldItem;
use App\Models\FieldType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

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
//        dd($field);
        $fieldValue = Field::updateOrCreate(
            [
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'field_type_id' => $field['field_type_id']
            ],
            [
                'position' => $field['position']
            ]
        );
        $this->field = Field::find($fieldValue->id);
//dd($this->field, $this->field->fieldItems);

        $this->fieldItems  = $this->field->fieldItems;
        $this->component  = $field['component'];
        unset($field['component']);
        $this->defaultFieldStore($field);
        switch ($this->component) {
            case FieldType::COMPONENT_HEADER:
            case FieldType::COMPONENT_HTML:
            case FieldType::COMPONENT_PARAGRAPH:
            case FieldType::COMPONENT_QUOTE:
            case FieldType::COMPONENT_SPOILER:
            case FieldType::COMPONENT_IFRAME:
                break;
            case FieldType::COMPONENT_FILE:
//                $this->storeFileBlock($blockData);
                break;
            case FieldType::COMPONENT_LIST:
                $this->storeList($field);
                break;
            case FieldType::COMPONENT_SLIDER:
                $this->storeImageBlock($field);
//                $this->setSeoService();
//                $this->setIframeFilter(false);
                break;
            case FieldType::COMPONENT_OPINION:
                $this->storeImageBlock($field);
//                $this->setSeoService();
//                $this->setIframeFilter();
                break;
        }
//        dd($this->getBody());
        return $this->renderedBody = $this->getBody();
    }

    /**
     * @param array $fieldData
     */
    private function defaultFieldStore(array $fieldData)
    {
//        dd($this->fieldItems);
        if ($this->fieldItems->isNotEmpty()) {
            $this->fieldItems->map(function ($field) {
                // TODO it doesn`t work))
                $field->translate(App::getLocale())->body = $field['body'];
                $field->save();
            });
        } else {
            $filteredBlockData = $fieldData;

            unset($filteredBlockData['field_items']);
//            dd($filteredBlockData);
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
        foreach ($field['field_items'] as $fieldItem) {
//            $this->fieldItem = isset($fieldItem['id']) ? FieldItem::find($fieldItem['id']) : null;
//            $this->fieldItem = isset($fieldItem['id']) ? FieldItem::find($fieldItem['id']) : null;
            $data = [
//                'id'   => $this->fieldItem,
                'body' => $fieldItem['name'],
            ];
//            dd($field['field_items'], $data, $this->fieldItem->translations());
            if ($this->fieldItem) {
                $this->fieldItem->update($data);
            } else {
                $this->fieldItems = FieldItem::create(
                    [
                        'name' => '',
                        'field_id' => $this->field->id,
                        App::getLocale() => [
                            'body' => $fieldItem['name']
                        ]
                    ]
                );
//                $this->fieldItem = $this->field
//                    ->fieldItems()
//                    ->create($data);
//                dd($this->fieldItems);
            }
        }
    }

    /**
     * @return string
     * @throws \Throwable
     */
    private function getBody(): string
    {
//        dd($this->field, $this->component, $this->fieldItem);
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
