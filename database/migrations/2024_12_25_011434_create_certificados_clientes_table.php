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
            $table->string('estado_validez')->default('Active');
            $table->date('fecha_inicio_validez')->nullable();
            $table->date('fecha_fin_validez')->nullable();
            $table->string('documento_pdf_validez')->nullable();
            $table->timestamps();
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