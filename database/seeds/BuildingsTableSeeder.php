<?php

use Illuminate\Database\Seeder;

class BuildingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buildings')->delete();
		$buildings = array(
		['name' => 'PMU Haupthaus'],
		['name' => 'PMU Wyss-Haus'],
		['name' => 'SALK'],
		);
		DB::table('buildings')->insert($buildings);
    }
}
