<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void { Schema::
create('transaksis', function (Blueprint $table) 
{ $table->id(); $table->foreignId('user_id')->constrained()->onDelete('cascade'); $table->enum('jenis', ['pemasukan', 'pengeluaran']); $table->string('kategori'); $table->decimal('jumlah', 15, 2); $table->string('catatan')->nullable(); $table->date('tanggal'); $table->timestamps(); }); } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
