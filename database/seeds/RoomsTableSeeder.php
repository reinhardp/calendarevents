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
		['name' => 'Hörsaal 1', 'building_id' => '2'],
		['name' => 'Hörsaal 2', 'building_id' => '2'],
		['name' => 'Hörsaal 8', 'building_id' => '1'],
		['name' => 'Cafe Relax', 'building_id' => '1'],
		['name' => 'EB-Raum 1', 'building_id' => '3'],
		['name' => 'EB-Raum 2', 'building_id' => '3'],
		);
		DB::table('rooms')->insert($rooms);
    }
}
