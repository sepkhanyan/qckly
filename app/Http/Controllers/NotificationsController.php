<?php

namespace App\Http\Controllers;

use App\Device;
use App\User;
use Illuminate\Http\Request;
use App\Notification;

class NotificationsController extends Controller
{
    public function sendNot($userId, $from, $msg, $order_id, $NotificationType = null, $type = null, $getDetails = null, $getDetailsOffers = null, $isForOfferList = false)
    {
        $devicetoken = Device::where('user_id', $userId)->where('device_type', 'android')->get();
        $Not_id = Notification::create([
            'to_device' => $userId,
            'from_device' => $from,
            'message' => $msg,
            'order_id' => $order_id
             
        ]);
        $device = array();
        $messages =
            [
                'NotificationId' => $Not_id->id,
                'message' => $msg,
//                'typeOfService' => $type,
                'order_id' => $order_id,
                 'NotificationType' => $NotificationType,

            ];
        foreach ($devicetoken as $dev) {
            $device[] = $dev->device_token;

        }
        // dd($device);
        // $this->sendToIos($messages, $msg, $userId);
        $this->sendToAndroid($messages, $device);
        // try {
        //     $this->dispatch(new sendToClientAndroid($messages, $device));
        //     $this->dispatch(new sendToClientiOS($messages, $msg, $userId));
        // } catch (Exception $e) {
        //     $e->getMessage();
        // }
    }



    public function sendToIos($messages, $msg, $userId)
    {
        // $tokenFilter = new TokenAuthController();
        /*
     *send push notification to client
     */
        //iOS app
    // Provide the Host Information.
        $tPort = 2195;
// Provide the Certificate and Key Data.
        // $tCert = public_path().'/AgentCertificate.pem';
        if (\App::environment('development') || \App::environment('local')) {
            // // Provide the Host Information.
            $tHost = 'gateway.sandbox.push.apple.com';
            // // Provide the Certificate and Key Data.
            // // if ($cert->certificate == 1) {
              $tCert = public_path().'/QcklyCertificates.p12';
            // // } else{
            // //    $tCert = public_path().'/AgentDevelopmentCertificates.pem';
            // // }
            // if ($cert->certificate == 1) {
            //     $tHost = 'gateway.push.apple.com';
            //     $tCert = public_path() . '/LiveAgentCertificate.pem';
            // } else {
            //     $tHost = 'gateway.sandbox.push.apple.com';
            //     $tCert = public_path() . '/DevAgentCertificates.pem';
            // }
        } else if (\App::environment('production')) {
            dd(1);
            // Provide the Host Information.
            $tHost = 'gateway.push.apple.com';
            // Provide the Certificate and Key Data.
            $tCert = public_path() . '/QcklyCertificates.p12';
            // if ($cert->certificate == 1) {
            //     $tHost = 'gateway.push.apple.com';
            //     $tCert = public_path() . '/LiveAgentCertificate.pem';
            // } else {
            //     $tHost = 'gateway.sandbox.push.apple.com';
            //     $tCert = public_path() . '/DevAgentCertificates.pem';
            // }
        }
// Provide the Private Key Passphrase (alternatively you can keep this secrete
// and enter the key manually on the terminal -> remove relevant line from code).
// Replace XXXXX with your Passphrase
        $tPassphrase = '';
// Provide the Device Identifier (Ensure that the Identifier does not have spaces in it).
// Replace this token with the token of the iOS device that is to receive the notification.
//$tToken = 'b3d7a96d5bfc73f96d5bfc73f96d5bfc73f7a06c3b0101296d5bfc73f38311b4';
        // $tToken = '6a2632d68789d54c33ea63e19a1251f13bea0cdb37bf6352acffc7d89f7fdefe';
//0a32cbcc8464ec05ac3389429813119b6febca1cd567939b2f54892cd1dcb134
// The message that is to appear on the dialog.
        // $tAlert = 'You have a LiveCode APNS Message';
// The Badge Number for the Application Icon (integer >=0).
        $tBadge = 1;
// Audible Notification Option.
        $tSound = 'default';
// The content that is returned by the LiveCode "pushNotificationReceived" message.
        $tPayload = 'APNS Message Handled by LiveCode';
// Create the message content that is to be sent to the device.
        $tBody['aps'] = array(
            "alert" => $msg,// 
            "message" => $messages,
            'sound' => $tSound,
            'content-available' => 1

        );
        //$tBody ['payload'] = $this->message;
        $tBody = json_encode($tBody);
        //$tBody = json_encode ($this->message);
// Create the Socket Stream.
        $tContext = stream_context_create();

        stream_context_set_option($tContext, 'ssl', 'local_cert', $tCert);
// Remove this line if you would like to enter the Private Key Passphrase manually.
        stream_context_set_option($tContext, 'ssl', 'passphrase', $tPassphrase);
// Open the Connection to the APNS Server.
        $tSocket = stream_socket_client('ssl://' . $tHost . ':' . $tPort, $error, $errstr, 30, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $tContext);
        // dd($tSocket);

// Check if we were able to open a socket.
        
        if (!$tSocket)
            exit ("APNS Connection Failed: $error $errstr" . PHP_EOL);
// Build the Binary Notification.
        $tResult = '';
        try {
            $devicetoken = Device::where('user_id', $userId)
                ->where('device_type', 'ios')
                ->orderBy('id', 'desc')->take(5)
                ->get();
            foreach ($devicetoken as $dev) {
                //$arrOfTokn   = $dev->device_token;
                // dump($dev->device_token);
                $tMsg = chr(0) . chr(0) . chr(32) . pack('H*', $this->filterToken($dev->device_token)) . pack('n', strlen($tBody)) . $tBody;
                $tResult = fwrite($tSocket, $tMsg, strlen($tMsg));
            }
        } catch (\Exception $e) {
        }
// Send the Notification to the Server.
        /*  if ($tResult)
            echo 'Delivered Message to APNS' . PHP_EOL;
          else
           echo 'Could not Deliver Message to APNS' . PHP_EOL;*/
// Close the Connection to the Server.
        fclose($tSocket);
    }

    public function sendToAndroid($message, $device)
    {
        // dd(1);
        $msg = array
        (
            'message'     => $message
        );
        $fields = array
        (
            'registration_ids'     => $device,
            'data'            => $msg
        );

        $headers = array
        (
            'Authorization: key=AAAADqKcxjE:APA91bEBFOqJeois_VnE6TIT33Nax62sCHwDKm_YHb9scdCrQ65i_rluwqwVKsCcDzVnzwbFEzx38XhvhPmapqXSDlqtNQgRSB9lGzZLiELjdFVv-G2XluwKYdTWxhBN72bSGc5FoiTw',
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        \Log::info($result);
        
        curl_close( $ch );

    }

    public function filterToken($token)
    {

        if (!is_string($token)) {
            throw new  InvalidArgumentException(sprintf(
                'Device token must be a string, "%s" given.',
                gettype($token)
            ));
        }

        if (preg_match('/[^0-9a-f]/', $token)) {
            throw new InvalidArgumentException(sprintf(
                'Device token must be mask "%s". Token given: "%s"',
                '/[^0-9a-f]/',
                $token
            ));
        }

        if (strlen($token) != 64) {
            throw new InvalidArgumentException(sprintf(
                'Device token must be a 64 charsets, Token length given: %d.',
                mb_strlen($token)
            ));
        }

        return $token;
    }

}
