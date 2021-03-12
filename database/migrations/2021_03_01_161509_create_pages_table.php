<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_templates', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('name');
            $table->string('alias');
            $table->string('body')->nullable();
            $table->boolean('can_have_child')->default(false);
            $table->boolean('can_be_child')->default(false);
            $table->boolean('is_menu')->default(false);

            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('alias')->index();
            $table->unsignedBigInteger('page_template_id');
            $table->unsignedBigInteger('parent_page_id')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('only_auth')->default(false);
            $table->boolean('use_sitemap')->default(true);
            $table->integer('position')->default(0);
            $table->string('body')->nullable();
            $table->timestamps();

            $table->foreign('page_template_id')
                ->references('id')
                ->on('page_templates')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('site_page', function (Blueprint $table) {
            $table->foreignId('site_id')
                ->references('id')
                ->on('sites');
            $table->foreignId('page_id')
                ->references('id')
                ->on('pages');
            $table->unique(['site_id', 'page_id']);
        });

        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('name');
            $table->string('url')->unique();
            $table->text('description')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_canonical')->nullable();
            $table->string('seo_robots')->nullable();
            $table->text('seo_content')->nullable();
            $table->string('locale')->index();

            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
