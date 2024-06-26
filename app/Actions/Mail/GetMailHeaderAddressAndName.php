<?php

namespace App\Actions\Mail;


use App\Models\Point;
use App\Models\Reservation;
use App\Models\Destination;

class GetMailHeaderAddressAndName
{
    public static function run(Reservation $reservation):string
    {

        switch ($reservation->destination->owner_id){
            case 1: $header = "Valamar Riviera d.d<br/>

                    Stancija Kaligari 1<br/>
                    Poreč, Republika Hrvatska<br/>
                   <br/>
                   OIB: 36201212847
                   <br/>
                   IBAN: HR4123600001101319202<br/>";

                  switch(app()->getLocale()){
                        case 'it':
                            $header .= "<i>Normativa sulla Privacy: https://www.valamar.com/it/normativa-sulla-privacy</i>";
                            break;
                      case 'en':
                          $header .= "<i>Privacy policy: https://valamar-riviera.com/en/privacy-policy/</i>";
                          break;
                      case 'hr':
                          $header .= "<i>Politika Privatnosti: https://www.valamar.com/hr/izjava-o-privatnosti</i>";
                          break;
                      case 'de':
                          $header .= "<i>Datenschutzrichtlinie: https://www.valamar.com/de/datenschutz</i>";
                          break;
                  }

                break;
            case 2:
                $header = "Valamar Riviera d.d<br/>

                    Stancija Kaligari 1<br/>
                    Poreč, Republika Hrvatska<br/>
                   <br/>
                   OIB: 36201212847
                   <br/>
                   IBAN: HR4123600001101319202<br/>";

                switch(app()->getLocale()){
                    case 'it':
                        $header .= "<i>Normativa sulla Privacy: https://www.valamar.com/it/normativa-sulla-privacy</i>";
                        break;
                    case 'en':
                        $header .= "<i>Privacy policy: https://valamar-riviera.com/en/privacy-policy/</i>";
                        break;
                    case 'hr':
                        $header .= "<i>Politika Privatnosti: https://www.valamar.com/hr/izjava-o-privatnosti</i>";
                        break;
                    case 'de':
                        $header .= "<i>Datenschutzrichtlinie: https://www.valamar.com/de/datenschutz</i>";
                        break;
                }
        }

        return $header;

    }

}
