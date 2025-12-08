<?php

namespace App\Filament\Resources\Bookings\Pages;

use App\Filament\Resources\Bookings\BookingResource;
use App\Models\Booking;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Override;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

}
