<?php

use Illuminate\Database\Seeder;
use App\Models\Theme;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $theme             = new Theme();
        $theme->name       = 'DefaultTheme';
        $theme->directory  = '/default_directory';
        $theme->is_default = true;
        $theme->save();
    }
}
