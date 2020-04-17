<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->commonFields();

            $table->unsignedBigInteger('image_types_id')->unsigned()->index()->nullable();
            $table->foreign('image_types_id')->references('id')->on('image_types')->onDelete('restrict');
            $table->string('route')->nullable();
            $table->string('name')->nullable();
            $table->string('seoname')->nullable();
            $table->string('extension', 6)->nullable();
            $table->string('alt', 124)->nullable();
            $table->text('sizes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
