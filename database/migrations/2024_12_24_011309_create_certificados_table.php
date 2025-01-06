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
        Schema::create('certificados', function (Blueprint $table) {
            $table->id();
            $table->string('curso')->unique(); // Número de certificado
            $table->date('fecha_inicio'); // Fecha de emisión
            $table->date('fecha_fin'); // Fecha de expiración
            $table->string('norma_cumplida'); // Norma cumplida
            $table->string('estado')->default('Active'); // Estado (Activo/Vencido)
            $table->string('documento_pdf')->nullable(); // Campo para almacenar la ruta del PDF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
