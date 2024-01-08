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
        Schema::create('rings', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('model_type_id')->unsigned();
            $table->foreign('model_type_id')
                ->references('id')->on('production_models')->onDelete('cascade');

            $table->double('capacity')->default(0);

            $table->bigInteger('flex_type_id')->unsigned();
            $table->foreign('flex_type_id')
                ->references('id')->on('flex_types')->onDelete('cascade');

            $table->double('bom')->default(0);
            $table->string('syspro_code')->nullable();

            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['model_type_id','flex_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rings');
    }
};
