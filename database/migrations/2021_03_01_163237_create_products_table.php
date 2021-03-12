<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_api_id');
            $table->boolean('available')->default(true);
            $table->unsignedBigInteger('base_currency_id');
            $table->string('alias');
            $table->boolean('active')->default(true);
            $table->integer('position')->default(0);

            $table->timestamps();

            $table->foreign('base_currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('cascade');
        });

        Schema::create('product_relations', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('relation_product_id');

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->foreign('relation_product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });

        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
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

            $table->unique(['product_id', 'locale']);
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });

        Schema::create('page_product', function (Blueprint $table) {
            $table->foreignId('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->unique(['page_id', 'product_id']);
        });

        Schema::create('site_product', function (Blueprint $table) {
            $table->foreignId('site_id')
                ->references('id')
                ->on('sites')
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->unique(['site_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
