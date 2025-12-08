<?php

namespace App\Filament\Resources\TimeSlots\Schemas;

use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class TimeSlotForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TimePicker::make('start_time')
                    ->required(),
                TimePicker::make('end_time')
                    ->required(),
            ]);
    }
}
