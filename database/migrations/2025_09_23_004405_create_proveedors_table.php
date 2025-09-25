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
        Schema::create('proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('domicilio');
            $table->string('ciudad');
            $table->char('cp', 5);
            $table->char('telefono', 10);
            $table->char('rfc', 13);
            $table->string('email');
            $table->string('password');
            $table->string('estado_proveedor')->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedors');
    }
};
