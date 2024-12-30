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
        Schema::create('certificados_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clientes_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('certificados_id')->constrained('certificados')->onDelete('cascade');
            $table->date('fecha_certificacion')->nullable(); // Campo adicional
            $table->timestamps();

            // Índices para mejorar el rendimiento de las consultas
            $table->index('clientes_id');
            $table->index('certificados_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados_clientes');
    }
};