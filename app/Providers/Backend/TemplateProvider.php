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
     * @param array $data
     * @param array $fields
     *
     * @return
     */
    public function storeTemplate(array $data, array $fields = [])
    {
//        dd($data, $fields);
        $this->pageTemplate = PageTemplate::create([
            'alias' => $data['alias'],
            'name' => $data['name'],
        ]);
//        $this->searchRepository    = $this->searchRepository
//            ->setNews($this->news)
//            ->storeIndexes($this->news->name, SearchIndexRepository::PRIORITY_1)
//            ->storeIndexes($this->news->subtitle, SearchIndexRepository::PRIORITY_2);
//        $this->news->block_item_id = $data['block_item_id'] ?? null;
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
//        $this->removeFields(Arr::pluck($fields, 'field_type_id'));
        $renderBody = '';
        dd($fields);
        foreach ($fields as $field) {
            $renderBody .= $this->blockRepository->store($this->pageTemplate, $field);
        }
        $this->pageTemplate->body = $renderBody;
//        $this->news->block_item_id = Str::isUuid($this->news->block_item_id) ? $this->news->block_item_id : null;
        $this->pageTemplate->save();

        return $this;
    }

    /**
     * @param array $newFieldIds
     */
    public function removeFields(array $newFieldIds)
    {
        $this->pageTemplate->fields->whereNotIn('id', $newFieldIds)
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
