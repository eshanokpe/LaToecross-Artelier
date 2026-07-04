<?php

namespace Tests\Feature;

use App\Models\Visitor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class TrackVisitorsMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_records_multiple_page_views_across_different_pages(): void
    {
        Notification::fake();

        Route::middleware('web')->get('/page-one', fn () => 'page one');
        Route::middleware('web')->get('/page-two', fn () => 'page two');

        $this->get('/page-one');
        $this->get('/page-two');

        $this->assertCount(2, Visitor::all());
        $this->assertEquals(['/page-one', '/page-two'], Visitor::query()->pluck('page_url')->map(fn ($url) => parse_url($url, PHP_URL_PATH))->all());
    }
}
