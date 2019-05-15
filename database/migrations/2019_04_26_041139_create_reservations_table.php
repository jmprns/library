<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rn');
            $table->integer('type');
            $table->integer('borrow_id');
            $table->integer('book_id');
            $table->integer('acc_id')->nullable();
            $table->integer('reserve_date');
            $table->integer('approve_date')->nullable();
            $table->integer('approve_by')->nullable();
            $table->integer('start')->nullable();
            $table->integer('end')->nullable();
            $table->integer('returned')->nullable();
            $table->integer('status')->default('1');
            $table->string('notes');
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
        Schema::dropIfExists('reservations');
    }
}
