<?php

namespace App\Mail\Guest;

use App\Models\Reservation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailable;

class ReservationModificationMail extends Mailable
{

    public $reservation;


    public function __construct($reservation_id, $locale)
    {
        $this->reservation = Reservation::findOrFail($reservation_id);
        \App::setLocale($locale);

        $display_id = $reservation_id;

        if($this->reservation->is_main != 1){
            $main_booking = Reservation::where('round_trip_id',$reservation_id)->get()->first();
            if(!empty($main_booking->status) && $main_booking->status == 'confirmed'){
                $display_id = $main_booking->id;
            }
        }

        switch ($this->reservation->confirmation_language){
            case 'en':
                $booking_confirmation = 'Confirmation of your transfer modification';
                break;
            case 'hr':
                $booking_confirmation = 'Potvrda vaše modifikacije transfer';
                break;

            case 'de':
                $booking_confirmation = 'Bestätigung Ihrer Überweisungsän derung';
                break;

            case 'it':
                $booking_confirmation = 'Conferma della modifica del trasferimento';
                break;
        }

        $this->subject(__('mail.guest.modification_mail.subject'));

        $pdf = PDF::loadView('attachments.voucher', ['reservation'=>$this->reservation])->setPaper('A4', 'portrait');
        $this->attachData($pdf->output(),"Voucher_{$display_id}.pdf");

        $pdf = PDF::loadView('attachments.booking_confirmation', ['reservation'=>$this->reservation])->setPaper('A4', 'portrait');
        $this->attachData($pdf->output(),"{$booking_confirmation}_{$display_id}.pdf");

        if($this->reservation->hasCancellationFee()){

            $booking_cancellation_fee = 'Cancellation Fee';

            switch ($this->reservation->confirmation_language){
                case 'hr':
                    $booking_cancellation_fee = 'Naknada Štete';
                    break;
                case 'de':
                    $booking_cancellation_fee = 'Stornogebühr';
                    break;
                case 'it':
                    $booking_cancellation_fee = 'Tassa di cancellazione';
                    break;
            }


            $pdf_cf = PDF::loadView('attachments.booking_cancellation_fee',['reservation'=>$this->reservation])->setPaper('A4', 'portrait');
            $this->attachData($pdf_cf->output(),"{$booking_cancellation_fee}_{$display_id}.pdf");
        }

    }

    public function build()
    {
        return $this->view('emails.guest.modification');
    }
}
