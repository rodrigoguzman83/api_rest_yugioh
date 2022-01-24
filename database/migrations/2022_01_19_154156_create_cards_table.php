<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->boolean('first_edition');
            $table->string('code', 50);
            $table->enum('type', ['monstruo', 'magica', 'trampa']);
            $table->string('sub_type', 50);
            $table->integer('state');
            $table->string('description', 150);
            $table->float('price', 8, 2);
            $table->string('image', 150)->nullable();
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
        Schema::dropIfExists('cards');
    }
}
