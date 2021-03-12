<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 3);
            $table->string('name')->nullable();
            $table->string('sign')->nullable();
            $table->integer('position')->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('default')->default(false);

            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('currency_id');
            $table->decimal('course', 12, 6);
            $table->timestamps();

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('cascade');
        });

        Schema::create('site_currency', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);

            $table->foreignId('site_id')
                ->references('id')
                ->on('sites')
                ->onDelete('cascade');
            $table->foreignId('currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('cascade');
            $table->unique(['site_id', 'currency_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
        Schema::dropIfExists('currencies');
    }
}
