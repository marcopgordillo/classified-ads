<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('price');
            $table->tinyInteger('discount');
            $table->text('description');
            $table->string('condition');
            $table->string('location');
            $table->string('phone');
            $table->boolean('is_published')->default(false);
            $table->string('featured_image');
            $table->string('image_one')->nullable();
            $table->string('image_two')->nullable();
            $table->string('image_three')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('country_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('state_id')->constrained()->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('city_id')->constrained()->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sub_category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('child_category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
