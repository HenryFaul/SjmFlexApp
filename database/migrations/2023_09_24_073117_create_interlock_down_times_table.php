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


        Schema::create('interlock_down_times', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('line_shift_id')->unsigned();
            $table->foreign('line_shift_id')
                ->references('id')->on('line_shifts')->onDelete('cascade');

            $table->bigInteger('interlock_line_id')->unsigned();
            $table->foreign('interlock_line_id')
                ->references('id')->on('interlock_lines')->onDelete('cascade');

            $table->bigInteger('interlock_down_time_type_id')->unsigned();
            $table->foreign('interlock_down_time_type_id')
                ->references('id')->on('interlock_down_time_types')->onDelete('cascade');

            $table->double('value')->default(0);
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('interlock_down_times');
    }
};
