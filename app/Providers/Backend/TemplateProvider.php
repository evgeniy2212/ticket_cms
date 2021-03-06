<?php

namespace App\Providers\Backend;

use App\Models\PageTemplate;
use Illuminate\Support\Arr;

class TemplateProvider
{
    /**
     * @var PageTemplate
     */
    private $pageTemplate;

    /**
     * @var FieldProvider
     */
    private $fieldProvider;

    /**
     * @param FieldProvider $fieldProvider
     */
    public function __construct(FieldProvider $fieldProvider)
    {
        $this->fieldProvider = $fieldProvider;
    }

    /**
     * @return PageTemplate
     */
    public function getTemplate(): PageTemplate
    {
        return $this->pageTemplate;
    }

    /**
     * @param array $data
     * @param array $fields
     *
     * @return
     */
    public function storeTemplate(array $data, array $fields = [])
    {
        $this->pageTemplate = PageTemplate::create([
            'alias' => $data['alias'],
            'name' => $data['name'],
        ]);
        $this->storeFields($fields);

        return $this;
    }

    /**
     * @param array $fields
     *
     * @return TemplateProvider
     */
    private function storeFields(array $fields): TemplateProvider
    {
//        dd($fields);
        $this->removeFields(Arr::pluck($fields, 'field_type_id'));
        $renderBody = '';

        foreach ($fields as $field) {
            $renderBody .= $this->fieldProvider->store($this->pageTemplate, $field);
        }
//        dd($renderBody);
        $this->pageTemplate->body = $renderBody;
        $this->pageTemplate->save();

        return $this;
    }

    /**
     * @param array $newFieldTypeIds
     */
    public function removeFields(array $newFieldTypeIds)
    {
//        dd($this->pageTemplate->fields, $newFieldTypeIds);
        $this->pageTemplate->fields->whereNotIn('field_type_id', $newFieldTypeIds)
            ->map(function ($field) {
//                $field->blockItems->map(function ($blockItem) {
//                    Storage::disk('public')->delete(BlockItem::IMAGES_PATH . $blockItem->id);
//                    $blockItem->delete();
//                    // TODO remove resized images
//                });
                $field->delete();
            });
    }
}
