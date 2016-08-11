<?php

use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->delete();
		$rooms = array(
		['title' => 'Hörsaal 1', 'building_id' => '2'],
		['title' => 'Hörsaal 2', 'building_id' => '2'],
		['title' => 'Hörsaal 8', 'building_id' => '1'],
		['title' => 'Cafe Relax', 'building_id' => '1'],
		['title' => 'EB-Raum 1', 'building_id' => '3'],
		['title' => 'EB-Raum 2', 'building_id' => '3'],
		);
		DB::table('rooms')->insert($rooms);
    }
}
