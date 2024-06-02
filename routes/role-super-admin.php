<?php

use App\Http\Controllers\EditUserController;
use App\Http\Controllers\MailRenderingController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Livewire\ActivityLogDashboard;
use App\Http\Livewire\CompanyOverview;
use App\Http\Livewire\DevMailPreview;
use App\Http\Livewire\LanguageOverview;
use App\Mail\Guest\ReservationCancellationMail;
use App\Models\Traveller;
use App\Services\Api\ValamarFiskalizacija;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Models\Reservation;

/*
    |--------------------------------------------------------------------------
    | Super admin role routes
    |--------------------------------------------------------------------------
    | These routes will be available for these roles:
    |  - SUPER-ADMIN
*/


Route::get('/phpinfo', function () {return view('phpini');})->name('phpinfo');


Route::get('laravel-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('laravel-logs');
Route::get('super-admin-dashboard', [SuperAdminDashboardController::class, 'show'])->name('super-admin-dashboard');
Route::get('/language-overview', LanguageOverview::class)->name('language-overview');
Route::get('edit-user/{user}', [EditUserController::class, 'showUser'])->name('edit-user');
Route::get('/company-overview', CompanyOverview::class)->name('company-overview');
Route::get('activity-log-dashboard', ActivityLogDashboard::class)->name('activity-log-dashboard');

Route::get('/test', function () {


    #886 -1
    #903 - 2
    #roundtrip cancelled - 884
    #one way cancelled - 879
    #mix cancellation roundtrip
    $reservation_id = 882;

    $type = 'booking-cancellation-fee';

    $reservation = Reservation::findOrFail($reservation_id);

    App::setLocale('de');

    switch ($type){
        case 'booking-confirmation':
            $view = 'attachments.booking_confirmation';
            break;
        case 'booking-cancellation':
            $view = 'attachments.booking_cancellation';
            $file_name = 'BookingCancellation'.$reservation_id.'.pdf';
            break;
        case 'booking-cancellation-fee':
            $view = 'attachments.booking_cancellation_fee';
            $file_name = 'BookingCancellationFee'.$reservation_id.'.pdf';
            break;
        case 'download-voucher':
            $view = 'attachments.voucher';
            $file_name = 'BookingVoucher_'.$reservation_id.'.pdf';
    }
    return \Barryvdh\DomPDF\Facade\Pdf::loadView($view, ['reservation'=> $reservation])->setPaper('A4', 'portrait')->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->stream();

});

Route::get('/dev-mail-preview', DevMailPreview::class)->name('dev-mail-preview');
Route::get('/res-mail-render/{type}/{id}', [MailRenderingController::class, 'renderReservationMail'])->name('res-mail-render');
