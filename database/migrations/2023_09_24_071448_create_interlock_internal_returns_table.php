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
        Schema::create('interlock_internal_returns', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('production_model_type_id')->unsigned();
            $table->foreign('production_model_type_id')
                ->references('id')->on('production_models')->onDelete('cascade');


            $table->bigInteger('line_shift_id')->unsigned();
            $table->foreign('line_shift_id')
                ->references('id')->on('line_shifts')->onDelete('cascade');

            $table->bigInteger('defect_bases_type_id')->unsigned();
            $table->foreign('defect_bases_type_id')
                ->references('id')->on('defect_bases')->onDelete('cascade');

            $table->bigInteger('internal_return_type_id')->unsigned();
            $table->foreign('internal_return_type_id')
                ->references('id')->on('internal_return_types')->onDelete('cascade');

            $table->double('value')->default(0);
            $table->double('salvage_value')->default(0);

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
        Schema::dropIfExists('interlock_internal_returns');
    }
};
