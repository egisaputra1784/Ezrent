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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('owner')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customer')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->decimal('harga', 15, 2);
            $table->date('tanggal_sewa');
            $table->date('tanggal_kembali');
            $table->enum('status', ['aktif', 'selesai', 'terlambat']);

            // Jaminan
            $table->enum('jaminan_tipe', ['uang', 'identitas'])->nullable();
            $table->decimal('jaminan_nilai', 15, 2)->nullable();
            $table->text('jaminan_detail')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
