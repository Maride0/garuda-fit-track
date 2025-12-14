<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AthletesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('athletes')->delete();
        
        \DB::table('athletes')->insert(array (
            0 => 
            array (
                'athlete_id' => 'ATH0001',
                'name' => 'Maryam Fatimah Ahyuddin',
                'avatar' => 'athletes/avatars/01KC92EPKJJKJBF9640H5YEV6E.jpg',
                'gender' => 'female',
                'birthdate' => '2004-08-21',
                'contact' => '+62 812-1353-5975',
                'sport_category' => 'olympic',
                'sport' => 'Tenis Meja',
                'height' => 161.0,
                'weight' => 46.0,
                'status' => 'fit',
                'last_screening_date' => '2025-12-09',
                'next_screening_due' => '2026-06-09',
                'created_at' => '2025-11-29 11:26:30',
                'updated_at' => '2025-12-12 10:42:07',
            ),
            1 => 
            array (
                'athlete_id' => 'ATH0002',
                'name' => 'Neva Talitha Amodia',
                'avatar' => NULL,
                'gender' => 'female',
                'birthdate' => '2005-09-17',
                'contact' => '+62 821-7243-3157',
                'sport_category' => 'olympic',
                'sport' => 'Berkuda',
                'height' => 163.0,
                'weight' => 45.0,
                'status' => 'restricted',
                'last_screening_date' => '2025-12-09',
                'next_screening_due' => '2025-12-30',
                'created_at' => '2025-11-29 13:45:47',
                'updated_at' => '2025-12-09 04:46:55',
            ),
            2 => 
            array (
                'athlete_id' => 'ATH0003',
                'name' => 'Vanesha Aulia Anggraeni',
                'avatar' => NULL,
                'gender' => 'female',
                'birthdate' => '2005-05-13',
                'contact' => '+62 813-2112-7021',
                'sport_category' => 'non_olympic',
                'sport' => 'Pencak Silat',
                'height' => 163.0,
                'weight' => 49.0,
                'status' => 'active_therapy',
                'last_screening_date' => '2025-12-09',
                'next_screening_due' => '2025-12-30',
                'created_at' => '2025-11-29 20:44:01',
                'updated_at' => '2025-12-09 04:24:59',
            ),
            3 => 
            array (
                'athlete_id' => 'ATH0004',
                'name' => 'Chepi Luna Sereniti',
                'avatar' => NULL,
                'gender' => 'female',
                'birthdate' => '2005-11-11',
                'contact' => '+62 895-0622-8904',
                'sport_category' => 'non_olympic',
                'sport' => 'Muay Thai',
                'height' => 170.0,
                'weight' => 50.0,
                'status' => 'fit',
                'last_screening_date' => '2025-12-13',
                'next_screening_due' => '2026-06-13',
                'created_at' => '2025-11-29 20:48:39',
                'updated_at' => '2025-12-13 08:40:30',
            ),
            4 => 
            array (
                'athlete_id' => 'ATH0005',
                'name' => 'Tyara Yulian Putri',
                'avatar' => NULL,
                'gender' => 'female',
                'birthdate' => '2005-07-14',
                'contact' => '+62 896-2885-8002',
                'sport_category' => 'olympic',
                'sport' => 'Anggar',
                'height' => 165.0,
                'weight' => 47.0,
                'status' => 'restricted',
                'last_screening_date' => '2025-12-09',
                'next_screening_due' => '2025-12-30',
                'created_at' => '2025-11-29 20:51:24',
                'updated_at' => '2025-12-09 04:45:55',
            ),
            5 => 
            array (
                'athlete_id' => 'ATH0006',
                'name' => 'Syakira Naura Amalia',
                'avatar' => NULL,
                'gender' => 'female',
                'birthdate' => '2005-05-08',
                'contact' => '+62 895-0569-4436',
                'sport_category' => 'olympic',
                'sport' => 'Bola Basket',
                'height' => 160.0,
                'weight' => 48.0,
                'status' => 'under_monitoring',
                'last_screening_date' => '2025-12-13',
                'next_screening_due' => '2026-06-13',
                'created_at' => '2025-11-29 20:53:21',
                'updated_at' => '2025-12-13 08:39:28',
            ),
            6 => 
            array (
                'athlete_id' => 'ATH0007',
                'name' => 'Brando Franco Windah',
                'avatar' => NULL,
                'gender' => 'male',
                'birthdate' => '1992-03-14',
                'contact' => '+62 898-8066-222',
                'sport_category' => 'non_olympic',
                'sport' => 'Esport',
                'height' => 185.0,
                'weight' => 82.0,
                'status' => 'active_therapy',
                'last_screening_date' => '2025-12-09',
                'next_screening_due' => '2025-12-30',
                'created_at' => '2025-11-29 20:59:13',
                'updated_at' => '2025-12-09 04:36:18',
            ),
            7 => 
            array (
                'athlete_id' => 'ATH0008',
                'name' => 'Farrel Dharmawan',
                'avatar' => NULL,
                'gender' => 'male',
                'birthdate' => '2004-07-03',
                'contact' => '+62 877-8752-2590',
                'sport_category' => 'olympic',
                'sport' => 'Bola Basket',
                'height' => 183.0,
                'weight' => 72.0,
                'status' => 'active_therapy',
                'last_screening_date' => '2025-12-09',
                'next_screening_due' => '2025-12-30',
                'created_at' => '2025-11-29 21:05:09',
                'updated_at' => '2025-12-09 04:38:19',
            ),
            8 => 
            array (
                'athlete_id' => 'ATH0009',
                'name' => 'Suara Jingga',
                'avatar' => NULL,
                'gender' => 'male',
                'birthdate' => '2005-12-08',
                'contact' => '+62 821-2789-4461',
                'sport_category' => 'olympic',
                'sport' => 'Panahan',
                'height' => 163.0,
                'weight' => 49.0,
                'status' => 'under_monitoring',
                'last_screening_date' => '2025-12-09',
                'next_screening_due' => '2026-06-09',
                'created_at' => '2025-11-29 21:32:18',
                'updated_at' => '2025-12-09 04:46:23',
            ),
            9 => 
            array (
                'athlete_id' => 'ATH0010',
                'name' => 'Jaudan Afzal',
                'avatar' => NULL,
                'gender' => 'male',
                'birthdate' => '2002-10-09',
                'contact' => '+62 812-9522-0076',
                'sport_category' => 'olympic',
                'sport' => 'Sepak Bola',
                'height' => 175.0,
                'weight' => 52.0,
                'status' => 'active_therapy',
                'last_screening_date' => '2025-12-09',
                'next_screening_due' => '2025-12-30',
                'created_at' => '2025-11-29 21:38:15',
                'updated_at' => '2025-12-09 04:44:05',
            ),
        ));
        
        
    }
}