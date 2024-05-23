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
        Schema::create('defect_types', function (Blueprint $table) {
            $table->id();
            $table->string('value')->unique();
            $table->text('comment')->nullable();
            $table->boolean('is_material_error')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('component');
            $table->integer('import_pos')->nullable();
            $table->bigInteger('defect_group_id')->unsigned();
            $table->foreign('defect_group_id')
                ->references('id')->on('defect_groups')->onDelete('cascade');
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
        Schema::dropIfExists('defect_types');
    }
};
