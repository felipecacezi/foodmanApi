<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_nome', 500);
            $table->string('item_unidade_medida', 4);
            $table->integer('item_qtd_minima');
            $table->integer('item_qtd_maxima');
            $table->integer('item_ativo'); // 0 para inativo e 1 para ativo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
