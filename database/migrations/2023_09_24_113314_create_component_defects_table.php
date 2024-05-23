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




        Schema::create('component_defects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('line_shift_id')->unsigned();
            $table->foreign('line_shift_id')
                ->references('id')->on('line_shifts')->onDelete('cascade');

            $table->bigInteger('component_line_id')->unsigned();
            $table->foreign('component_line_id')
                ->references('id')->on('component_lines')->onDelete('cascade');

            $table->bigInteger('defect_type_id')->unsigned();
            $table->foreign('defect_type_id')
                ->references('id')->on('defect_types')->onDelete('cascade');

            $table->bigInteger('defect_bases_type_id')->unsigned();
            $table->foreign('defect_bases_type_id')
                ->references('id')->on('defect_bases')->onDelete('cascade');

            $table->boolean('is_inc')->default(true);
            $table->double('value')->default(0);
            $table->double('salvage_value')->default(0);
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('component_defects');
    }
};
