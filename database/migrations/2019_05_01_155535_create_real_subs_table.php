<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\RealSub;

class CreateRealSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_subs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        RealSub::create([
            'name' => 'English'
        ]);

        RealSub::create([
            'name' => 'Math'
        ]);

        RealSub::create([
            'name' => 'Filipino'
        ]);

        RealSub::create([
            'name' => 'Science'
        ]);

        RealSub::create([
            'name' => 'MAPEH'
        ]);

        RealSub::create([
            'name' => 'Araling Panlipunan'
        ]);

        RealSub::create([
            'name' => 'Values Education'
        ]);

        RealSub::create([
            'name' => 'TLE'
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_subs');
    }
}
