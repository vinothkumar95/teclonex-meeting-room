<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create(['name'=>'Room 1','description'=> "Room 1 description"]);
        Room::create(['name'=>'Room 2','description'=> "Room 2 description"]);
        Room::create(['name'=>'Room 3','description'=> "Room 3 description"]);
    }
}
