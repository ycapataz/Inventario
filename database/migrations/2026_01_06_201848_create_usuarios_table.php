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
            Schema::create('usuarios', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 150);
                $table->string('correo', 150);
                $table->string('dni', 10);

                // 🔑 Llave foránea
                //llave foranes de usuarios a equipos.
                $table->foreignId('equipo_id')
                    ->nullable()
                    ->constrained('equipos')
                    ->nullOnDelete();

                $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
