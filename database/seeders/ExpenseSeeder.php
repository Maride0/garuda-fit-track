<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'latihan', 
            'peralatan',
            'kesehatan',
            'kompetisi',
            'akomodasi',
            'lainnya',
        ];

        $statuses = ['paid', 'reimbursed'];

        $applicants = [
            'Maryam Fatimah Ahyuddin',
            'Neva Talitha',
            'Vanesha Aulia',
            'Tyara Yulian',
            'Chepi Luna',
        ];

        $descriptions = [
            'Pembelian peralatan latihan untuk sesi minggu ini.',
            'Penggantian biaya transportasi menuju venue kompetisi.',
            'Pembelian obat dan suplemen pemulihan atlet.',
            'Biaya akomodasi selama mengikuti kompetisi luar kota.',
            'Pengeluaran untuk konsumsi atlet selama latihan intensif.',
            'Pembelian perlengkapan kesehatan dan tape cedera.',
            'Sewa lapangan untuk sesi latihan reguler.',
            'Biaya perbaikan peralatan yang rusak.',
            'Pembelian air mineral dan kebutuhan logistik atlet.',
            'Biaya registrasi kompetisi tingkat kota.',
        ];

        for ($i = 1; $i <= 10; $i++) {

            DB::table('expenses')->insert([
                'expenses_code' => 'EXP-' . now()->format('Ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'expense_date' => now()->subDays(rand(1, 60))->format('Y-m-d'),
                'applicant_name' => $applicants[array_rand($applicants)],
                'type' => $types[array_rand($types)],
                'amount' => rand(100000, 5000000),
                'description' => $descriptions[array_rand($descriptions)],
                'status' => $statuses[array_rand($statuses)],
                'receipt' => rand(0, 1) ? 'receipts/dummy_' . Str::random(8) . '.jpg' : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
