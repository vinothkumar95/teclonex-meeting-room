<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slots = [
            ['09:00', '09:30'],
            ['09:30', '10:00'],
            ['10:00', '10:30'],
            ['10:30', '11:00'],
            ['11:00', '11:30'],
            ['11:30', '12:00'],
            ['12:00', '12:30'],
            ['12:30', '13:00'],
            ['13:00', '13:30'],
            ['13:30', '14:00'],
            ['14:00', '14:30'],
            ['14:30', '15:00'],
            ['15:00', '15:30'],
            ['15:30', '16:00'], 
            ['16:00', '16:30'],
            ['16:30', '17:00'],
            ['17:00', '17:30'],
            ['17:30', '18:00'],
        ];
        $availableSlots = [];
        foreach ($slots as $slot) {
           $availableSlots[] =  [
                'start_time' => $slot[0],
                'end_time' => $slot[1],
                'created_at' => now(),
                'updated_at' => now(),
           ];
            
        }

        TimeSlot::insert($availableSlots);
        
    }
}
