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
        Schema::create('payables', function (Blueprint $table) {
	        $table->string('id', 36)->primary(); // UUID/ULID em string
	        $table->string('descricao', 160);
	        $table->integer('valor_em_centavos');
	        $table->char('moeda', 3);
	        $table->date('vencimento');
	        $table->integer('parcela')->nullable();
	        $table->integer('total_parcelas')->nullable();
	        $table->timestampTz('pago_em')->nullable();
	        $table->string('comprovante_path')->nullable();
        	$table->timestampsTz();
	        $table->index(['vencimento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payables');
    }
};
