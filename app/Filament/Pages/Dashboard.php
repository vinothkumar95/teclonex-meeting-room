<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CalendarWidget;
use App\Filament\Widgets\UserStatWidget;
use Filament\Pages\Page;
use Filament\Pages\Concerns\HasWidgets;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class Dashboard extends Page
{
    protected string $view = 'filament.pages.dashboard';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected function getHeaderWidgets(): array
    {
        return [
            UserStatWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 3;
    }
}
