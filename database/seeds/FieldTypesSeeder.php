<?php

use Illuminate\Database\Seeder;
use App\Models\FieldType;
use App\Models\Field;

class FieldTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name'      => 'Header',
                'icon'      => 'heading',
                'component' => Field::COMPONENT_HEADER,
            ],
            [
                'name'      => 'List',
                'icon'      => 'list',
                'component' => Field::COMPONENT_LIST,
            ],
            [
                'name'      => 'HTML5',
                'icon'      => 'html',
                'component' => Field::COMPONENT_HTML,
            ],
            [
                'name'      => 'Image',
                'icon'      => 'file-image',
                'component' => Field::COMPONENT_SLIDER,
            ],
            [
                'name'      => 'File',
                'icon'      => 'file',
                'component' => Field::COMPONENT_FILE,
            ],
            [
                'name'      => 'Iframe',
                'icon'      => 'info-circle',
                'component' => Field::COMPONENT_IFRAME,
            ],
        ];

        foreach ($types as $type) {
            FieldType::updateOrcreate(['component' => $type['component']], $type);
        }
    }
}
