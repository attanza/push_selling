<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50);
            $table->unsignedInteger('seller_id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('outlet_id');
            $table->smallInteger('qty');
            $table->boolean('verified')->default(0);
            $table->date('verified_at')->nullable();
            $table->unsignedInteger('supervisor_id')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
