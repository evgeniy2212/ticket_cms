<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->string('component')->nullable();
            $table->boolean('is_active')->default(true);
        });

        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('field_type_id')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('list_type')->nullable()->comment('used to define list type(ul/ol)');
            $table->boolean('visible')->default(true);
            $table->timestamps();

            $table
                ->foreign('field_type_id')
                ->references('id')
                ->on('field_types')
                ->nullOnDelete();
        });

        Schema::create('field_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('field_id');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable()->comment('for iframe type it will be url');
            $table->mediumText('body')->nullable()->comment('ready page layout');
            $table->string('locale')->index();

            $table->unique(['field_id', 'locale']);
            $table->foreign('field_id')
                ->references('id')
                ->on('fields')
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
        Schema::dropIfExists('field_translations');
        Schema::dropIfExists('fields');
        Schema::dropIfExists('field_types');
    }
}
