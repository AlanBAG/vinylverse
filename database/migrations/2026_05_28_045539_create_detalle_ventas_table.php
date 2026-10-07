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
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->decimal('precio_unitario',10,2);
            $table->decimal('subtotal',10,2);

            $table->foreignId('id_ventas')
                ->constrained('ventas')
                ->onDelete('cascade');

            $table->foreignId('vinilo_id')
                ->constrained('vinilos')
                ->onDelete('cascade');

            $table->boolean('estado');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_ventas');
    }
};
