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
            $table->float('longitude');
            $table->float('latitude');
            $table->string('title');
            $table->string('slug');
            $table->string('address');
            $table->string('city');
            $table->text('cover_img');
            $table->text('description');
            $table->unsignedTinyInteger('number_of_rooms');
            $table->unsignedTinyInteger('number_of_bathrooms');
            $table->unsignedTinyInteger('square_meters')->nullable();
            $table->unsignedDecimal('price', 7,2 );
            $table->boolean('visibility');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down(){
        Schema::table('apartments', function (Blueprint $table) {
            $table->dropForeign('apartments_user_id_foreign');
            $table->dropColumn('user_id');
        });
        
        Schema::dropIfExists('apartments');
    }
};
