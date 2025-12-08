<?php

namespace App\Filament\Widgets;

use App\Models\BlogPost;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\CarbonImmutable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class UserStatWidget extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    public function getStats(): array
    {
        return [
            Stat::make(
                label: 'Total users',
                value: User::count(),
            ),
            Stat::make(
                label: 'Total Bookings',
                value: Booking::count(),
            ),
            Stat::make(
                label: 'Total Rooms',
                value: Room::count(),
            ),
        ];
    }
}
