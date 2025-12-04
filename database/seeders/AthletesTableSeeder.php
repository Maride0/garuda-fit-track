<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AthletesTableSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('athletes')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::unprepared(<<<SQL
INSERT INTO `athletes` (`athlete_id`, `name`, `gender`, `birthdate`, `contact`, `sport_category`, `sport`, `height`, `weight`, `status`, `last_screening_date`, `next_screening_due`, `created_at`, `updated_at`) VALUES('ATH0001', 'Maryam Fatimah Ahyuddin', 'female', '2004-08-21', '+62 812-1353-5975', 'olympic', 'Tenis Meja', 161, 46, 'not_screened', NULL, NULL, '2025-11-29 11:26:30', '2025-11-29 22:27:46');
INSERT INTO `athletes` (`athlete_id`, `name`, `gender`, `birthdate`, `contact`, `sport_category`, `sport`, `height`, `weight`, `status`, `last_screening_date`, `next_screening_due`, `created_at`, `updated_at`) VALUES('ATH0002', 'Neva Talitha Amodia', 'female', '2005-09-17', '+62 821-7243-3157', 'olympic', 'Berkuda', 163, 45, 'not_screened', NULL, NULL, '2025-11-29 13:45:47', '2025-11-29 22:27:46');
INSERT INTO `athletes` (`athlete_id`, `name`, `gender`, `birthdate`, `contact`, `sport_category`, `sport`, `height`, `weight`, `status`, `last_screening_date`, `next_screening_due`, `created_at`, `updated_at`) VALUES('ATH0003', 'Vanesha Aulia Anggraeni', 'female', '2005-05-13', '+62 813-2112-7021', 'non_olympic', 'Pencak Silat', 163, 49, 'not_screened', NULL, NULL, '2025-11-29 20:44:01', '2025-11-29 23:42:15');
INSERT INTO `athletes` (`athlete_id`, `name`, `gender`, `birthdate`, `contact`, `sport_category`, `sport`, `height`, `weight`, `status`, `last_screening_date`, `next_screening_due`, `created_at`, `updated_at`) VALUES('ATH0004', 'Chepi Luna Sereniti', 'female', '2005-11-11', '+62 895-0622-8904', 'non_olympic', 'Muay Thai', 170, 50, 'not_screened', NULL, NULL, '2025-11-29 20:48:39', '2025-11-29 21:09:58');
INSERT INTO `athletes` (`athlete_id`, `name`, `gender`, `birthdate`, `contact`, `sport_category`, `sport`, `height`, `weight`, `status`, `last_screening_date`, `next_screening_due`, `created_at`, `updated_at`) VALUES('ATH0005', 'Tyara Yulian Putri', 'female', '2005-07-14', '+62 896-2885-8002', 'olympic', 'Anggar', 165, 47, 'not_screened', NULL, NULL, '2025-11-29 20:51:24', '2025-11-29 21:10:12');
INSERT INTO `athletes` (`athlete_id`, `name`, `gender`, `birthdate`, `contact`, `sport_category`, `sport`, `height`, `weight`, `status`, `last_screening_date`, `next_screening_due`, `created_at`, `updated_at`) VALUES('ATH0006', 'Syakira Naura Amalia', 'female', '2005-05-08', '+62 895-0569-4436', 'olympic', 'Bola Basket', 160, 48, 'not_screened', NULL, NULL, '2025-11-29 20:53:21', '2025-11-29 21:10:35');
INSERT INTO `athletes` (`athlete_id`, `name`, `gender`, `birthdate`, `contact`, `sport_category`, `sport`, `height`, `weight`, `status`, `last_screening_date`, `next_screening_due`, `created_at`, `updated_at`) VALUES('ATH0007', 'Brando Franco Windah', 'male', '1992-03-14', '+62 898-8066-222', 'non_olympic', 'Esport', 185, 82, 'not_screened', NULL, NULL, '2025-11-29 20:59:13', '2025-11-29 21:11:02');
INSERT INTO `athletes` (`athlete_id`, `name`, `gender`, `birthdate`, `contact`, `sport_category`, `sport`, `height`, `weight`, `status`, `last_screening_date`, `next_screening_due`, `created_at`, `updated_at`) VALUES('ATH0008', 'Farrel Dharmawan', 'male', '2004-07-03', '+62 877-8752-2590', 'olympic', 'Bola Basket', 183, 72, 'not_screened', NULL, NULL, '2025-11-29 21:05:09', '2025-11-29 21:11:51');
INSERT INTO `athletes` (`athlete_id`, `name`, `gender`, `birthdate`, `contact`, `sport_category`, `sport`, `height`, `weight`, `status`, `last_screening_date`, `next_screening_due`, `created_at`, `updated_at`) VALUES('ATH0009', 'Suara Jingga', 'male', '2005-12-08', '+62 821-2789-4461', 'olympic', 'Panahan', 163, 49, 'not_screened', NULL, NULL, '2025-11-29 21:32:18', '2025-11-29 21:52:14');
INSERT INTO `athletes` (`athlete_id`, `name`, `gender`, `birthdate`, `contact`, `sport_category`, `sport`, `height`, `weight`, `status`, `last_screening_date`, `next_screening_due`, `created_at`, `updated_at`) VALUES('ATH0010', 'Jaudan Afzal', 'male', '2002-10-09', '+62 812-9522-0076', 'olympic', 'Sepak Bola', 175, 52, 'not_screened', NULL, NULL, '2025-11-29 21:38:15', '2025-11-29 21:38:15');
SQL);
    }
}
