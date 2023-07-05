<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('material_name');
            $table->text('material_description')->nullable();

            $table->foreignId('category_id')
            ->nullable()
            ->constrained('categories','id');

            $table->foreignId('modifiertemplate_id')
            ->nullable()
            ->constrained('modifier_templates','id');

            $table->bigInteger('reference_id')->nullable();
            $table->string('materialimg')->nullable();
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
        Schema::dropIfExists('materials');
    }
}
