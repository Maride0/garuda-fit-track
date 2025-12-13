<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // kalau ada user role coach/athlete, amanin dulu jadi admin (atau supervisor—pilih yang masuk akal)
        DB::statement("UPDATE users SET role='admin' WHERE role IN ('coach','athlete')");

        // pangkas enum
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','supervisor') NOT NULL DEFAULT 'admin'");
    }

    public function down(): void
    {
        // balikin enum lama (coach/athlete) kalau kamu butuh rollback
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin','coach','athlete','supervisor') NOT NULL DEFAULT 'admin'");
    }
};
