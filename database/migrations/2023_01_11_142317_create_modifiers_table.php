<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modifiers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('modifier_name');

            $table->foreignId('modifiertemplate_id')
            ->constrained('modifier_templates','id');

            $table->integer('modifier_index')->default(-1);
            $table->float('modifier_price')->default(0);
            $table->bigInteger('reference_id')->nullable();

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
        Schema::dropIfExists('modifiers');
    }
}
