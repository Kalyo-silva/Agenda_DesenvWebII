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
        Schema::table('users', function (Blueprint $table) {
            // Adiciona o campo id_pessoa como chave estrangeira
            $table->unsignedBigInteger('id_pessoa')->nullable();

            // Definir a chave estrangeira que faz referência à tabela pessoas
            $table->foreign('id_pessoa')
                  ->references('id')->on('pessoas')
                  ->onDelete('set null'); // Caso a pessoa seja excluída, o id_pessoa será setado como null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove a chave estrangeira
            $table->dropForeign(['id_pessoa']);
            
            // Remove o campo id_pessoa
            $table->dropColumn('id_pessoa');
        });
    }
};
