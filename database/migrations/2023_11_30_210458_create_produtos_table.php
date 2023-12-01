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
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('produto_nome', 500);
            $table->text('produto_descricao');
            $table->integer('produto_qtd_minima');
            $table->integer('produto_qtd_maxima');
            $table->integer('produto_valor');
            $table->integer('produto_ativo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
