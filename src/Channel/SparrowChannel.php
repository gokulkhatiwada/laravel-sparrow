<?php


namespace Aankhijhyaal\LaraSparrow\Channel;


use Illuminate\Notifications\Notification;
use Aankhijhyaal\LaraSparrow\Exceptions\SmsMessageNotDefined;
use Aankhijhyaal\LaraSparrow\Exceptions\SparrowDataNotDefined;
use Aankhijhyaal\LaraSparrow\Exceptions\SparrowConfigurationsNotDefined;
use Aankhijhyaal\LaraSparrow\Exceptions\SparrowSmsException;
use Aankhijhyaal\LaraSparrow\SmsMessage;

class SparrowChannel
{

  public function send($notifiable, Notification $notification)
  {

    if(is_null(config('sparrow.token')) || is_null(config('sparrow.url')) || is_null(config('sparrow.identity'))){
      throw new SparrowConfigurationsNotDefined('Sparrow configurations not defined.',500);
    }

    if(method_exists($notification, 'toSparrow')){
      $message = $notification->toSparrow($notifiable);
    } else {
      throw new SparrowDataNotDefined('toSparrow() method not defined in '.get_class($notification),500);
    }

    if(!$message instanceof SmsMessage){
      throw new SmsMessageNotDefined('toSparrow() must return instance of '. SmsMessage::class);
    }

    $response = $this->sendSms($message->getRecipient(),$message->getContent());
    if($response['code'] !== 200){
      throw new SparrowSmsException('Expected status code 200 got '.$response['code'].'. '
          .$response['response']['response'].'. Response Code: '.$response['response']['response_code'],$response['code']);
    }
  }

  public function sendSms($route, $data)
  {

    $url = config('sparrow.url');
    $token = config('sparrow.token');
    $from = config('sparrow.identity');

    $args = http_build_query(array(
        'token' => $token,
        'from'  => $from,
        'to'    => $route,
        'text'  => $data
    ));


    # Make the call using API.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Response
    $response = curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['code'=>$statusCode,'response'=>json_decode($response,true)];
  }


}

