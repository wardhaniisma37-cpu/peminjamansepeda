<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            // Tambah kolom processed_by jika belum ada
            if (!Schema::hasColumn('loans', 'processed_by')) {
                $table->foreignId('processed_by')->nullable()->after('user_id')->constrained('users')->nullOnDelete();
            }
            
            // Tambah kolom condition_return jika belum ada
            if (!Schema::hasColumn('loans', 'condition_return')) {
                $table->enum('condition_return', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang'])->nullable()->after('status');
            }
            
            // Tambah kolom damage_description jika belum ada
            if (!Schema::hasColumn('loans', 'damage_description')) {
                $table->text('damage_description')->nullable()->after('condition_return');
            }
            
            // Tambah kolom penalty_amount jika belum ada
            if (!Schema::hasColumn('loans', 'penalty_amount')) {
                $table->integer('penalty_amount')->default(0)->after('damage_description');
            }
            
            // Tambah kolom payment_method jika belum ada
            if (!Schema::hasColumn('loans', 'payment_method')) {
                $table->enum('payment_method', ['cash', 'transfer'])->nullable()->after('penalty_amount');
            }
            
            // Tambah kolom payment_proof jika belum ada
            if (!Schema::hasColumn('loans', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('payment_method');
            }
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $columns = ['processed_by', 'condition_return', 'damage_description', 'penalty_amount', 'payment_method', 'payment_proof'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('loans', $column)) {
                    if ($column === 'processed_by') {
                        $table->dropForeign(['processed_by']);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};