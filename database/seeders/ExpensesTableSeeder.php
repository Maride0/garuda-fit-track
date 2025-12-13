<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExpensesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('expenses')->delete();
        
        \DB::table('expenses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'expenses_code' => 'EXP-20251208-001',
                'expense_date' => '2025-12-05',
                'applicant_name' => 'Chepi Luna',
                'type' => 'peralatan',
                'amount' => '2686104',
                'description' => 'Pengeluaran untuk konsumsi atlet selama latihan intensif.',
                'status' => 'reimbursed',
                'receipt' => NULL,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            1 => 
            array (
                'id' => 2,
                'expenses_code' => 'EXP-20251208-002',
                'expense_date' => '2025-11-17',
                'applicant_name' => 'Neva Talitha',
                'type' => 'peralatan',
                'amount' => '283435',
                'description' => 'Pembelian air mineral dan kebutuhan logistik atlet.',
                'status' => 'reimbursed',
                'receipt' => 'receipts/dummy_04MYuGup.jpg',
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            2 => 
            array (
                'id' => 3,
                'expenses_code' => 'EXP-20251208-003',
                'expense_date' => '2025-12-07',
                'applicant_name' => 'Vanesha Aulia',
                'type' => 'kesehatan',
                'amount' => '316902',
                'description' => 'Pembelian obat dan suplemen pemulihan atlet.',
                'status' => 'paid',
                'receipt' => 'receipts/dummy_jfHITamT.jpg',
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            3 => 
            array (
                'id' => 4,
                'expenses_code' => 'EXP-20251208-004',
                'expense_date' => '2025-10-10',
                'applicant_name' => 'Tyara Yulian',
                'type' => 'lainnya',
                'amount' => '3063175',
                'description' => 'Biaya akomodasi selama mengikuti kompetisi luar kota.',
                'status' => 'reimbursed',
                'receipt' => 'receipts/dummy_qZnXM7Yk.jpg',
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            4 => 
            array (
                'id' => 5,
                'expenses_code' => 'EXP-20251208-005',
                'expense_date' => '2025-11-22',
                'applicant_name' => 'Neva Talitha',
                'type' => 'peralatan',
                'amount' => '2099511',
                'description' => 'Pembelian peralatan latihan untuk sesi minggu ini.',
                'status' => 'reimbursed',
                'receipt' => NULL,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            5 => 
            array (
                'id' => 6,
                'expenses_code' => 'EXP-20251208-006',
                'expense_date' => '2025-10-14',
                'applicant_name' => 'Chepi Luna',
                'type' => 'kesehatan',
                'amount' => '2972163',
                'description' => 'Pengeluaran untuk konsumsi atlet selama latihan intensif.',
                'status' => 'paid',
                'receipt' => 'receipts/dummy_gIbfcg91.jpg',
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            6 => 
            array (
                'id' => 7,
                'expenses_code' => 'EXP-20251208-007',
                'expense_date' => '2025-10-18',
                'applicant_name' => 'Vanesha Aulia',
                'type' => 'kompetisi',
                'amount' => '3860417',
                'description' => 'Biaya akomodasi selama mengikuti kompetisi luar kota.',
                'status' => 'reimbursed',
                'receipt' => 'receipts/dummy_3ApNj8nn.jpg',
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            7 => 
            array (
                'id' => 8,
                'expenses_code' => 'EXP-20251208-008',
                'expense_date' => '2025-10-12',
                'applicant_name' => 'Maryam Fatimah Ahyuddin',
                'type' => 'latihan',
                'amount' => '4714713',
                'description' => 'Pengeluaran untuk konsumsi atlet selama latihan intensif.',
                'status' => 'reimbursed',
                'receipt' => 'receipts/dummy_Cl1iJ6tt.jpg',
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            8 => 
            array (
                'id' => 9,
                'expenses_code' => 'EXP-20251208-009',
                'expense_date' => '2025-11-21',
                'applicant_name' => 'Chepi Luna',
                'type' => 'kompetisi',
                'amount' => '677551',
                'description' => 'Sewa lapangan untuk sesi latihan reguler.',
                'status' => 'paid',
                'receipt' => NULL,
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
            9 => 
            array (
                'id' => 10,
                'expenses_code' => 'EXP-20251208-010',
                'expense_date' => '2025-11-10',
                'applicant_name' => 'Neva Talitha',
                'type' => 'kompetisi',
                'amount' => '4072451',
                'description' => 'Biaya akomodasi selama mengikuti kompetisi luar kota.',
                'status' => 'reimbursed',
                'receipt' => 'receipts/dummy_0t6K4QOV.jpg',
                'created_at' => '2025-12-08 11:09:10',
                'updated_at' => '2025-12-08 11:09:10',
            ),
        ));
        
        
    }
}