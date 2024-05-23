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



        Schema::create('down_time_types', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->text('comment')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('component');
            $table->softDeletes();
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
        Schema::dropIfExists('down_time_types');
    }
};
