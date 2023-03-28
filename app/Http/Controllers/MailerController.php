<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Appointment;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Message;
use App\Models\Service;
use App\Models\Type;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerController extends BaseController
{
    public function compose_reply(Request $request, $id)
    {
        require base_path('vendor/autoload.php');

        $message = Message::find($id);

        try {
            $mail = new PHPMailer(true);

            // Email server settings

            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'k71608883429@ktch.hu';
            $mail->Password = 'rgvbtvrkzjdccolq';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587; // 587 or 465

            $mail->setFrom($mail->Username);
            $mail->addAddress($message->email);

            $mail->isHTML(true);

            $mail->Subject = "RE: " . $message->subject . " - Zold Pont";
            $mail->Body = "<h2>Kedves " . $message->name . "!</h2>\r\n"
                . "<p>" . $request->body . "</p>" .
                "\r\n<i>Üdvözlettel,\r\nMárti, ZoldPont</i>";

            if (!$mail->send()) {
                return $this->sendError($mail->ErrorInfo, "Hiba a valaszkuldes soran.");
            } else {
                return $this->sendResponse($mail, 'Sikeres valasz.');
            }
        } catch (Exception $e) {
            return back()->with('error', 'Nem tudtam elkuldeni.');
        }
    }

    public function compose_feedback(Request $request, $bookingId)
    {
        require base_path('vendor/autoload.php');
        try {
            $mail = new PHPMailer(true);
            $booking = Booking::find($bookingId);
            $booking = new BookingResource($booking);
            $service = Service::find($booking->service_id);
            $client = Client::find($booking->client_id);
            $type = Type::find($booking->type_id);
            $apt = Appointment::find($booking->appointment_id);

            // Email server settings

            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'k71608883429@ktch.hu';
            $mail->Password = 'rgvbtvrkzjdccolq';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587; // 587 or 465

            $mail->setFrom($mail->Username);
            $mail->addAddress("csenge.balogh1214@gmail.com");

            $mail->isHTML(true);

            $mail->Subject = "ZP - Foglalás visszaigazolása";
            $mail->Body = "<h2>Kedves " . $client->fullName . "!</h2>\r\n" .
                "<p>Ezt az e-mailt azért kapod, mert időpontot foglaltál hozzám masszázsra a weboldalamon.</p>
            
            <p>Ezúton értesítelek, hogy a foglalásod jóváhagyásra került általam, szeretettel várlak a megjelölt időpontban.</p>

            <p><strong>Az időpontod:</strong> " . $apt->date . ", " . $apt->start . "</p>

            <p><strong>Helyszín: </strong> 1102 Budapest, Harmat utca 12. </p>

            <p>Kérlek a megadott időpontra pontosan érkezz! Amennyiben késve érkezel, a masszázsod idejéből vonódik le. A kezelés összege/részösszege ilyen esetben nem visszatérítendő.</p>
            
            <strong>A szolgáltatás részletei:</strong>\r\n
            
            <table>
                <tr>
                    <td>Masszázs típusa:</td>
                    <td>" . $service->name . "</td>
                </tr>
                <tr>
                    <td>Az érintett testrészek:</td>
                    <td>" . $type->name . "</td>
                </tr>
                <tr>
                    <td>Időtartam:</td>
                    <td>" . $type->duration . " perc</td>
                </tr>
                <tr>
                    <td>Ár:</td>
                    <td>" . $type->price . " Ft</td>
                </tr>
            </table>
            
            <p>A fenti összeget a stúdióban a masszázs után készpénzben vagy bankkártyával is tudod fizetni. A kifizetésről készült számla a helyszínen, az alábbi címre kerül kiállításra:</p>

            " . $client->fullAddress . "

            <p>Szeretettel várlak a szalonban!</p>

            <p>Üdvözlettel, <br> Márti</p>
            ";

            if (!$mail->send()) {
                return $this->sendError($mail->ErrorInfo, "Hiba a valaszkuldes soran.");
            } else {
                return $this->sendResponse($mail, 'Sikeres valasz.');
            }
        } catch (Exception $e) {
            return back()->with('error', 'Nem tudtam elkuldeni.');
        }
    }
}
