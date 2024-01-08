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


        Schema::create('line_shifts', function (Blueprint $table) {
            $table->id();
            $table->date('shift_date');
            $table->bigInteger('shift_type_id')->unsigned();
            $table->foreign('shift_type_id')
                ->references('id')->on('shifts')->onDelete('cascade');
            $table->text('comment')->nullable();
            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['shift_date','shift_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('line_shifts');
    }
};
