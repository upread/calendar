<?php
namespace App\Telegram;

class Telegram
{
    function sendMessage($tg_chat_id, $message, $keyboard = "") {
        $response = array(
            'chat_id' => $tg_chat_id,
            'text' => $message,
            'parse_mode' => "HTML"
        );

        if ($keyboard){
            $arr = array('reply_markup' => json_encode($keyboard, TRUE));
            $response = array_merge($response, $arr);
        }

        $ch = curl_init('https://api.telegram.org/bot' . env("TG_TOKEN_BOT") . '/sendMessage');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_exec($ch);
        curl_close($ch);
    }

}

?>
