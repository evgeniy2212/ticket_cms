<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('theme_id');
            $table->string('name')->nullable();
            $table->string('domain');

            $table->timestamps();
            $table->foreign('theme_id')
                ->references('id')
                ->on('themes');
        });

        Schema::create('site_locale', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);

            $table->foreignId('site_id')
                ->references('id')
                ->on('sites')
                ->onDelete('cascade');
            $table->foreignId('locale_id')
                ->references('id')
                ->on('locales')
                ->onDelete('cascade');
            $table->unique(['site_id', 'locale_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}
