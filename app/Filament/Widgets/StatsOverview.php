<?php

namespace App\Filament\Widgets;

use App\Models\Artwork;
use App\Models\Fashion;
use App\Models\SupportTicket;
use App\Models\FashionEnquiry;
use App\Models\ArtworkEnquiry;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Artworks Stats
            Stat::make('Total Artworks', Artwork::count())
                ->description('All art pieces')
                ->descriptionIcon('heroicon-o-paint-brush')
                ->color('amber')
                ->chart([7, 3, 10, 5, 8, 12, 9])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            Stat::make('Artworks For Sale', Artwork::where('is_for_sale', true)->count())
                ->description('Available to purchase')
                ->descriptionIcon('heroicon-o-tag')
                ->color('emerald')
                ->chart([4, 6, 8, 5, 7, 9, 11])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            Stat::make('Artworks Sold', Artwork::where('is_for_sale', false)->count())
                ->description('Sold pieces')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('gray')
                ->chart([3, 4, 5, 6, 4, 3, 5])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            // Fashion Stats
            Stat::make('Total Fashion Pieces', Fashion::count())
                ->description('Wearable art & designs')
                ->descriptionIcon('heroicon-o-scissors')
                ->color('rose')
                ->chart([5, 8, 6, 10, 7, 9, 12])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            Stat::make('Fashion For Sale', Fashion::where('is_for_sale', true)->count())
                ->description('Available designs')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->color('orange')
                ->chart([3, 5, 7, 6, 8, 10, 9])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            Stat::make('Fashion Sold', Fashion::where('is_for_sale', false)->count())
                ->description('Sold designs')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('gray')
                ->chart([2, 3, 4, 5, 3, 4, 6])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            // Support Tickets Stats
            Stat::make('Total Support Tickets', SupportTicket::count())
                ->description('All support tickets')
                ->descriptionIcon('heroicon-o-ticket')
                ->color('indigo')
                ->chart([2, 4, 3, 5, 6, 4, 8])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            Stat::make('Unread Tickets', SupportTicket::where('is_read', false)->count())
                ->description('Tickets awaiting review')
                ->descriptionIcon('heroicon-o-clock')
                ->color('danger')
                ->chart([1, 2, 3, 2, 4, 3, 5])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            Stat::make('Pending Tickets', SupportTicket::where('status', 'pending')->count())
                ->description('Need attention')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('warning')
                ->chart([2, 3, 2, 4, 3, 5, 4])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            Stat::make('Resolved Tickets', SupportTicket::where('status', 'resolved')->count())
                ->description('Successfully resolved')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->chart([1, 2, 1, 3, 2, 4, 3])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            // Fashion Enquiries Stats
            Stat::make('Fashion Enquiries', FashionEnquiry::count())
                ->description('Total fashion enquiries')
                ->descriptionIcon('heroicon-o-chat-bubble-left-right')
                ->color('pink')
                ->chart([2, 3, 5, 4, 6, 8, 7])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            Stat::make('Unread Fashion Enquiries', FashionEnquiry::where('is_read', false)->count())
                ->description('Need attention')
                ->descriptionIcon('heroicon-o-clock')
                ->color('danger')
                ->chart([1, 2, 3, 2, 4, 3, 5])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            // Artwork Enquiries Stats
            Stat::make('Artwork Enquiries', ArtworkEnquiry::count())
                ->description('Total artwork enquiries')
                ->descriptionIcon('heroicon-o-chat-bubble-left-right')
                ->color('purple')
                ->chart([3, 4, 6, 5, 7, 9, 8])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),

            Stat::make('Unread Artwork Enquiries', ArtworkEnquiry::where('is_read', false)->count())
                ->description('Need attention')
                ->descriptionIcon('heroicon-o-clock')
                ->color('danger')
                ->chart([1, 3, 2, 4, 3, 5, 4])
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-gray-50 transition-all duration-300',
                ]),
        ];
    }

    /**
     * Get the columns configuration for the stats overview.
     */
    protected function getColumns(): int
    {
        return 4;
    }

    /**
     * Get the polling interval for the widget.
     */
    protected function getPollingInterval(): ?string
    {
        return '30s';
    }
}
 https://latoecross.com/