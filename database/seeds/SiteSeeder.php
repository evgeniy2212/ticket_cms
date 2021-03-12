<?php

use Illuminate\Database\Seeder;
use App\Models\Site;
use App\Models\Theme;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $site = new Site();
        $site->theme_id = Theme::default()->first()->id;
        $site->name     = 'BestSite';
        $site->domain   = 'test_domain.com';
        $site->save();
    }
}
