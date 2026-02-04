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
        Schema::table('pesertadidiks', function (Blueprint $table) {
            if (!Schema::hasColumn('pesertadidiks', 'warga_negara')) {
                $table->string('warga_negara')->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('pesertadidiks', 'ijazah_smp')) {
                $table->string('ijazah_smp')->nullable()->after('sekolah_asal');
            }
            if (!Schema::hasColumn('pesertadidiks', 'tanggal_ijazah_smp')) {
                $table->date('tanggal_ijazah_smp')->nullable()->after('ijazah_smp');
            }
            if (!Schema::hasColumn('pesertadidiks', 'tanggal_meninggalkan')) {
                $table->date('tanggal_meninggalkan')->nullable()->after('diterima');
            }
            if (!Schema::hasColumn('pesertadidiks', 'alasan_meninggalkan')) {
                $table->string('alasan_meninggalkan')->nullable()->after('tanggal_meninggalkan');
            }
            if (!Schema::hasColumn('pesertadidiks', 'no_ijazah_akhir')) {
                $table->string('no_ijazah_akhir')->nullable()->after('alasan_meninggalkan');
            }
            if (!Schema::hasColumn('pesertadidiks', 'tanggal_ijazah_akhir')) {
                $table->date('tanggal_ijazah_akhir')->nullable()->after('no_ijazah_akhir');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesertadidiks', function (Blueprint $table) {
            $table->dropColumn([
                'warga_negara',
                'ijazah_smp',
                'tanggal_ijazah_smp',
                'tanggal_meninggalkan',
                'alasan_meninggalkan',
                'no_ijazah_akhir',
                'tanggal_ijazah_akhir'
            ]);
        });
    }
};
