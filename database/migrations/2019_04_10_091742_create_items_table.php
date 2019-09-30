<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('seller_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->string('image_path')->nullable();;
            $table->decimal('starting_price', 28 ,18)->unsigned();
            $table->decimal('reserve_price', 25, 18)->unsigned();
            $table->string('currency');
            $table->date('end_date');
            $table->string('seller_address');
            $table->string('contract_address');
            $table->string('status')->default('active');

            $table->timestamps();
        });
    
       /*  Schema::table('items', function($table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
 */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
