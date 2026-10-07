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
        Schema::create('vinilos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('genero');
            $table->integer('anio_lanzamiento');
            $table->integer('numero_canciones');
            $table->decimal('precio', 10, 2);
            $table->integer('stock');
            $table->string('formato');
            $table->string('discografia');
            $table->text('descripcion');
            $table->string('imagen')->nullable();
            $table->boolean('estado');
            $table->foreignId('artista_id')
                ->constrained('artistas')
                ->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vinilos');
    }
};
