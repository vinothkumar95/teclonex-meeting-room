<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Models\Booking;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Closure;
use Illuminate\Support\Facades\Log;
use Filament\Schemas\Components\Utilities\Get;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'email') // assumes name column exists
                    ->searchable()
                    ->required(),

                Select::make('room_id')
                    ->label('Room')
                    ->relationship('room', 'name')
                    ->searchable()
                    ->required()
                    ->reactive(),
                Select::make('time_slot_id')
                    ->label('Time Slot')
                    ->options(
                        TimeSlot::all()->mapWithKeys(fn($s) => [$s->id => date('g:i A', strtotime($s->start_time)).' - '.date('g:i A', strtotime($s->end_time))])
                    )
                    ->required()
                    ->reactive(),

                    DatePicker::make('date')
                    ->required()
                    ->minDate(Carbon::today())
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                            Log::info($value,[$get('room_id'),$get('time_slot_id')]);

                            $roomId = $get('room_id') ?? null;
                            $slotId = $get('time_slot_id') ?? null;
            
                            if (!$roomId || !$slotId || !$value) {
                                return;
                            }
            
                            $exists = \App\Models\Booking::where('room_id', $roomId)
                                ->where('time_slot_id', $slotId)
                                ->where('date', $value)
                                ->exists();
            
                            if ($exists) {
                                $fail('This time slot is already booked for the selected room and date.');
                            }

                        },
                    ])
            ]);

    }
}
