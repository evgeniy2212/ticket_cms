<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id');

            $table->timestamps();
        });

        Schema::create('sample_lists', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->bigInteger('model_id');
            $table->unsignedBigInteger('sample_id');

            $table->timestamps();
            $table->foreign('sample_id')
                ->references('id')
                ->on('samples')
                ->onDelete('cascade');
        });

        Schema::create('sample_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sample_list_id');
            $table->string('name')->nullable();
            $table->string('locale')->index();

            $table->unique(['sample_list_id', 'locale']);
            $table->foreign('sample_list_id')
                ->references('id')
                ->on('sample_lists')
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
        Schema::dropIfExists('sample_translations');
        Schema::dropIfExists('sample_lists');
        Schema::dropIfExists('samples');
    }
}
