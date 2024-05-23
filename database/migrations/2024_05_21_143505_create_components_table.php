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
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->string('component');
            $table->bigInteger('model_type_id')->unsigned();
            $table->foreign('model_type_id')
                ->references('id')->on('production_models')->onDelete('cascade');

            $table->double('component_value')->default(0);
            $table->string('component_type')->nullable();
            $table->bigInteger('flex_type_id')->unsigned();
            $table->foreign('flex_type_id')
                ->references('id')->on('flex_types')->onDelete('cascade');

            $table->string('location')->nullable();
            $table->string('cutting_type')->nullable();
            $table->integer('corr')->nullable();

            $table->double('bom')->default(0);
            $table->string('syspro_code')->nullable();

            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('components');
    }
};
