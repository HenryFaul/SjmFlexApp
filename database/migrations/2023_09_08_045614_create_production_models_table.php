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
        Schema::create('production_models', function (Blueprint $table) {
            $table->id();
            $table->string('model')->nullable();

            $table->bigInteger('flex_type_id')->unsigned();
            $table->foreign('flex_type_id')
                ->references('id')->on('flex_types')->onDelete('cascade');

            $table->text('comment')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['model','flex_type_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('production_models');
    }
};
