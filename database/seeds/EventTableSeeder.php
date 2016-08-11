<?php


use Illuminate\Database\Seeder;
class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// clean table 'events'
        DB::table('events')->delete();
 
 		// specify the value to be insert to table 'events'
        $events = array(
			['title' => 'Test', 'details' => 'Keine', 'start' => '2016-08-05', 'end' => '' , 'created_at' => new DateTime, 'updated_at' => new DateTime, 'resourceid' => '1', 'starttime' => '08:00', 'endtime'=>'09:00'],
        );

		// insert data into table 'events' 
        DB::table('events')->insert($events);
    }
}
