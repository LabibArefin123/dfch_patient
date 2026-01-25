<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use App\Models\Tender;
use App\Models\TenderParticipate;
use App\Models\TenderAwarded;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        app('router')->aliasMiddleware('permission', \App\Http\Middleware\CheckPermission::class);

        $today = Carbon::today();
        $daysToCheck = [15, 7, 3, 2, 1];

        $totalTenders = 0;
        $totalOfferValidity = 0;
        $totalBGExpiring = 0;
        $totalPGExpiring = 0;
        $totalAwardedDate = 0;

        foreach ($daysToCheck as $day) {
            $targetDate = $today->copy()->addDays($day);

            $totalTenders += Tender::where('status', 0)
                ->whereDate('submission_date', $targetDate)
                ->count();

            $totalOfferValidity += TenderParticipate::whereDate('offer_validity', $targetDate)->count();

            $totalAwardedDate += TenderAwarded::whereDate('awarded_date', $targetDate)
                ->whereHas('tenderParticipate.tender', function ($q) {
                    $q->where('status', '!=', 4);
                })->count();

            $totalBGExpiring += TenderParticipate::whereHas('bg', function ($q) use ($targetDate) {
                $q->whereDate('expiry_date', $targetDate);
            })->count();

            $totalPGExpiring += TenderAwarded::whereHas('pg', function ($q) use ($targetDate) {
                $q->whereDate('expiry_date', $targetDate);
            })->count();
        }

        config([
            'adminlte.notification_counts.tender' => $totalTenders,
            'adminlte.notification_counts.offer_validity' => $totalOfferValidity,
            'adminlte.notification_counts.bg' => $totalBGExpiring,
            'adminlte.notification_counts.pg' => $totalPGExpiring,
            'adminlte.notification_counts.delivery' => $totalAwardedDate,
        ]);

        $menu = config('adminlte.menu');

        foreach ($menu as &$item) {
            if (isset($item['id']) && $item['id'] === 'notificationBell') {
                $total = $totalTenders + $totalOfferValidity + $totalBGExpiring + $totalPGExpiring + $totalAwardedDate;

                // This sets the red badge number (Facebook-style)
                $item['label'] = (string) $total;
                $item['label_color'] = 'danger';

                foreach ($item['submenu'] as &$submenu) {
                    if (str_contains($submenu['text'], 'Tender List')) {
                        $submenu['text'] = "Tender List ({$totalTenders})";
                    } elseif (str_contains($submenu['text'], 'Offer Validity')) {
                        $submenu['text'] = "Tender Participated Offer Validity List ({$totalOfferValidity})";
                    } elseif (str_contains($submenu['text'], 'Bid Guarantee')) {
                        $submenu['text'] = "Bid Guarantee (BG) List ({$totalBGExpiring})";
                    } elseif (str_contains($submenu['text'], 'Tender Awarded Delivery Date List')) {
                        $submenu['text'] = "Tender Awarded Delivery Date List ({$totalAwardedDate})";
                    } elseif (str_contains($submenu['text'], 'Performance Guarantee')) {
                        $submenu['text'] = "Performance Guarantee (PG) List ({$totalPGExpiring})";
                    }
                }
            }
        }


        config(['adminlte.menu' => $menu]);
    }
}
