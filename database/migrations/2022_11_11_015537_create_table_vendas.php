<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->string('comprador')->nullable();
            $table->string('descricao')->nullable();
            $table->string('quantidade')->nullable();
            $table->string('endereco', 500)->nullable();
            $table->string('fornecedor')->nullable();
            $table->double('preco_unitario', 16, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};
