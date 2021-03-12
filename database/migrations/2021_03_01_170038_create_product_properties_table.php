<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_properties', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(true);
            $table->string('name');
            $table->string('alias');

            $table->timestamps();
        });

        Schema::create('product_property_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('product_property_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->unsignedBigInteger('product_property_id');
            $table->unsignedBigInteger('product_property_type_id');
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('product_property_id')
                ->references('id')
                ->on('product_properties')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('product_property_type_id')
                ->references('id')
                ->on('product_property_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('product_property_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_property_field_id');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('product_property_field_id')
                ->references('id')
                ->on('product_property_fields')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('product_property_value_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_property_value_id');
            $table->text('value')->nullable();
            $table->string('locale')->index();

            $table->foreign('product_property_value_id', 'p_p_value')
                ->references('id')
                ->on('product_property_values')
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
        Schema::dropIfExists('product_properties');
    }
}
