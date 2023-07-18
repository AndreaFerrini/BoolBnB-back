<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('longitude',8,5);
            $table->decimal('latitude',8,5);
            $table->string('title',100);
            $table->string('slug',100);
            $table->string('address',100);
            $table->string('city',50);
            $table->text('cover_img')->nullable();
            $table->text('description');
            $table->unsignedTinyInteger('number_of_rooms');
            $table->unsignedTinyInteger('number_of_bathrooms');
            $table->unsignedTinyInteger('square_meters')->nullable();
            $table->unsignedDecimal('price', 7,2 );
            $table->boolean('visibility')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down(){
        Schema::dropIfExists('apartments');
    }
};
