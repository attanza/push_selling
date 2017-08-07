<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutletSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlet_sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('outlet_id');
            $table->unsignedInteger('seller_id');
            $table->unsignedInteger('supervisor_id')->nullable();
            $table->boolean('verified')->default(0);
            $table->date('verified_at')->nullable();
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
        Schema::dropIfExists('outlet_sellers');
    }
}
