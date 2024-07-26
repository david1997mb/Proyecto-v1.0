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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onUpdate('cascade')->onDelete('restrict');
            $table->dateTime('reserve_at')->useCurrent();
            $table->enum('type',['Matrimonio','Cumpleaños','Reuniones','Bautizo']);
            $table->date('event_date')->required();
            $table->integer('guests')->nullable();
            $table->decimal('cost',10,2)->nullable();
            $table->enum('status',['Completado','Cancelado','Pagando']);
            $table->double('saldo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
