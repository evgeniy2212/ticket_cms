<?php

namespace App\Providers\Backend;

use App\Models\Page;
use App\Models\PageTemplate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class PageProvider
{
    /**
     * @var Page
     */
    private $page;

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
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * @param array $data
     * @param array $fields
     *
     * @return
     */
    public function storePage(array $data, array $fields = [])
    {
//        dd($data);
        $this->page = Page::create([
            'alias' => $data['alias'],
            'page_template_id' => PageTemplate::first()->id,
            App::getLocale() => [
                'name' => $data['name'],
                'url' => $data['alias'],
            ]
        ]);
        $this->storeFields($fields);

        return $this;
    }

    /**
     * @param array $fields
     *
     * @return PageProvider
     */
    private function storeFields(array $fields): PageProvider
    {
//        dd($fields);
        $this->removeFields(Arr::pluck($fields, 'field_type_id'));
        $renderBody = '';


        foreach ($fields as $field) {
            $renderBody .= $this->fieldProvider->store($this->page, $field);
        }

        $this->page->body = $renderBody;
        $this->page->save();

        return $this;
    }

    /**
     * @param array $newFieldTypeIds
     */
    public function removeFields(array $newFieldTypeIds)
    {
//        dd($this->pageTemplate->fields, $newFieldTypeIds);
        $this->page->fields->whereNotIn('field_type_id', $newFieldTypeIds)
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
