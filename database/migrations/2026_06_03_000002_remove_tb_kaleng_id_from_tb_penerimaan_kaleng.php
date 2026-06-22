<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('tb_penerimaan_kaleng')) {
            Schema::table('tb_penerimaan_kaleng', function (Blueprint $table) {
                if (Schema::hasColumn('tb_penerimaan_kaleng', 'tb_kaleng_id')) {
                    // drop foreign and column
                    $table->dropForeign(['tb_kaleng_id']);
                    $table->dropColumn('tb_kaleng_id');
                }

                if (!Schema::hasColumn('tb_penerimaan_kaleng', 'keterangan')) {
                    $table->string('keterangan')->nullable()->after('jumlah');
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('tb_penerimaan_kaleng')) {
            Schema::table('tb_penerimaan_kaleng', function (Blueprint $table) {
                if (!Schema::hasColumn('tb_penerimaan_kaleng', 'tb_kaleng_id')) {
                    $table->unsignedBigInteger('tb_kaleng_id')->nullable()->after('id');
                    $table->foreign('tb_kaleng_id')->references('id')->on('tb_kaleng')->onDelete('cascade');
                }

                if (Schema::hasColumn('tb_penerimaan_kaleng', 'keterangan')) {
                    $table->dropColumn('keterangan');
                }
            });
        }
    }
};
