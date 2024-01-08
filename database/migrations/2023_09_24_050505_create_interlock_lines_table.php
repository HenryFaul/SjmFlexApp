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



        Schema::create('interlock_lines', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('line_shift_id')->unsigned();
            $table->foreign('line_shift_id')
                ->references('id')->on('line_shifts')->onDelete('cascade');

            $table->string('job_card_no')->nullable();

            $table->bigInteger('flex_type_id')->unsigned();
            $table->foreign('flex_type_id')
                ->references('id')->on('flex_types')->onDelete('cascade');

            $table->bigInteger('production_model_type_id')->unsigned();
            $table->foreign('production_model_type_id')
                ->references('id')->on('production_models')->onDelete('cascade');

            $table->bigInteger('interlock_type_id')->unsigned();
            $table->foreign('interlock_type_id')
                ->references('id')->on('interlocks')->onDelete('cascade');

            $table->bigInteger('shift_leader_id')->unsigned();
            $table->foreign('shift_leader_id')
                ->references('id')->on('staff_members')->onDelete('cascade');

            $table->bigInteger('operator_id')->unsigned();
            $table->foreign('operator_id')
                ->references('id')->on('staff_members')->onDelete('cascade');

            $table->bigInteger('business_unit_id')->unsigned();
            $table->foreign('business_unit_id')
                ->references('id')->on('business_units')->onDelete('cascade');

            $table->bigInteger('assembly_line_id')->unsigned();
            $table->foreign('assembly_line_id')
                ->references('id')->on('assembly_lines')->onDelete('cascade');

            $table->double('prod_capacity')->default(0);
            $table->double('prod_plan')->default(0);
            $table->double('prod_actual')->default(0);

            $table->double('prod_return')->default(0);
            $table->double('prod_salvage')->default(0);

            $table->double('prod_qty_loss')->default(0);
            $table->double('prod_percent_loss')->default(0);

            $table->double('work_time')->default(0);
            $table->double('sum_down_time')->default(0);
            $table->double('work_down_time')->default(0);

            $table->double('man_input')->default(0);

            $table->double('total_defect_qty_inc')->default(0);
            $table->double('total_defect_qty_ex')->default(0);

            $table->double('total_defect_qty_conv_inc')->default(0);
            $table->double('total_defect_qty_conv_ex')->default(0);

            $table->double('total_defect_kg_inc')->default(0);
            $table->double('total_defect_kg_ex')->default(0);

            $table->double('total_defect_percent_inc')->default(0);
            $table->double('total_defect_percent_ex')->default(0);

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
        Schema::dropIfExists('interlock_lines');
    }
};
