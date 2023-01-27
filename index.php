<?php

require './vendor/autoload.php';

use Telegram\Bot\Api;

$client = new Api('5985602812:AAFRbavRYfe0q-XHFQC9-1X7isImb7AG20Q');

$last_update_id = 0;

while (true) {

    $response = $client->getUpdates(['offset' => $last_update_id, 'timeout' => 5]);

    if (count($response) <= 0) continue;

    foreach ($response as $r) {

        $last_update_id = $r->getUpdateId() + 1;
        $message = $r->getMessage();
        $chatId = $message->getChat()->getId();

        $arr = Command($message->getText());
        $text = $arr["text"];
        $photo = $arr["photo"];

        $response = $client->sendPhoto([
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $text,
        ]);
    }
}

function Command($comando)
{
    switch ($comando) {
        case "/start":
            return GetStarted();
            break;
        case "/anime":
            return GetAnime();
            break;
        case "/maniglio":
            return GetHandle();
            break;
        case "/costa":
            return GetCosta();
            break;
        default:
            return "Comando non riconosciuto, prova con /start";
            break;
    }
}

function GetStarted()
{
    return array("photo" => "./ph/dario.png", "text" => "Comandi disponibili\n/start per comprendere\n/anime per conoscere\n/maniglio per ordinare un kebabon\n/costa per hackerare i server del MC Donald");
}

function GetAnime()
{

    $rating = 60;
    while ($rating < 80) {
        $random = rand(1, 100);

        //get data from the online api
        $api_url = 'https://kitsu.io/api/edge/anime/' . $random;
        $json_data = file_get_contents($api_url);
        $response_data = json_decode($json_data);
        $data = $response_data->data;

        //create the message
        $rating = $data->{"attributes"}->{"averageRating"};
        $anime_poster = $data->{"attributes"}->{"posterImage"}->{"large"};
        $anime_name = $data->{"attributes"}->{"canonicalTitle"};
        $anime_nameJP = $data->{"attributes"}->{"titles"}->{"ja_jp"};
        $anime_rating = "Rating: " . $rating;
        $anime_description = $data->{"attributes"}->{"synopsis"};

        $text = $anime_name . "\n" . $anime_nameJP . "\n" . $anime_rating . "\n";

        $arr = array("photo" => $anime_poster, "text" => $text, "id" => $random);
    }
    return $arr;
}

function GetHandle()
{
    return array("photo" => "./ph/maniglio.jpg", "text" => "kebab ordinato de pefforza");
}

function GetCosta()
{
    return array("photo" => "./ph/costa.jpg", "text" => "il più grande hacker di tutti i tempi");
}