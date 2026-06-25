<?php

namespace App\Filament\Widgets;

use App\Models\Artwork;
use App\Models\Fashion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Artworks', Artwork::count())
                ->description('All art pieces')
                ->descriptionIcon('heroicon-o-paint-brush')
                ->color('amber'),

            Stat::make('Total Fashion Pieces', Fashion::count())
                ->description('Wearable art & designs')
                ->descriptionIcon('heroicon-o-scissors')
                ->color('rose'),

            Stat::make('Artworks For Sale', Artwork::where('is_for_sale', true)->count())
                ->description('Available to purchase')
                ->descriptionIcon('heroicon-o-tag')
                ->color('emerald'),

            Stat::make('Fashion For Sale', Fashion::where('is_for_sale', true)->count())
                ->description('Available designs')
                // ✅ Changed from invalid "o-bag" to valid "o-shopping-bag"
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('orange'),
        ];
    }
}