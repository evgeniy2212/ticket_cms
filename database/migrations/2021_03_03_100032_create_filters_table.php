<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filter_type_id');
            $table->integer('position')->default(0);
            $table->string('alias')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('filter_type_id')
                ->references('id')
                ->on('filter_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('filter_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filter_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('locale')->index();

            $table->unique(['filter_id', 'locale']);

            $table->foreign('filter_id')
                ->references('id')
                ->on('filters')
                ->onDelete('cascade');
        });

        Schema::create('filter_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filter_id');
            $table->integer('position')->default(0);
            $table->boolean('active')->default(true);
            $table->string('alias');
            $table->timestamps();

            $table->unique(['filter_id', 'alias']);

            $table->foreign('filter_id')
                ->references('id')
                ->on('filters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('filter_value_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('filter_value_id');
            $table->string('name');
            $table->string('locale')->index();

            $table->unique(['filter_value_id', 'locale']);

            $table->foreign('filter_value_id')
                ->references('id')
                ->on('filter_values')
                ->onDelete('cascade');
        });

        Schema::create('filter_page', function (Blueprint $table) {
            $table->foreignId('filter_id')
                ->references('id')
                ->on('filters')
                ->onDelete('cascade');

            $table->foreignId('page_id')
                ->references('id')
                ->on('pages')
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
        Schema::dropIfExists('filters');
    }
}
