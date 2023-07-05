<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_units', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('material_unit_name');

            $table->foreignId('material_id')
            ->constrained('materials','id')->cascadeOnDelete();

            $table->unique(['id', 'material_id']);
            $table->bigInteger('reference_id')->nullable();
            $table->double('price')->default(0);
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
        Schema::dropIfExists('material_units');
    }
}
