<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use app\Models\Pessoa;
use app\Models\Evento;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evento_pessoas', function (Blueprint $table) {
            $table->id();
            $table->integer('pessoa_id')->unsigned();
            $table->integer('evento_id')->unsigned();
            $table->enum('tipo_pessoa', ['Profissional', 'Acolhido'])->nullable()->after('pessoa_id');;
            $table->timestamps();

            $table->foreign('pessoa_id')->references('id')->on('pessoas');
            $table->foreign('evento_id')->references('id')->on('eventos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_pessoas');
    }
};
