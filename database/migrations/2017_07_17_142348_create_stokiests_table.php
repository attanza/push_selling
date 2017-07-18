<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStokiestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stokiests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50);
            $table->string('name', 50);
            $table->string('owner', 50);
            $table->string('pic', 50);
            $table->string('phone1', 50);
            $table->string('phone2', 50)->nullable();
            $table->string('email', 150);
            $table->text('address')->nullable();
            $table->string('photo')->nullable();
            $table->float('lat', 10, 6)->nullable();
            $table->float('lng', 10, 6)->nullable();
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
        Schema::dropIfExists('stokiests');
    }
}
