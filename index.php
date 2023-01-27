<?php

require './vendor/autoload.php';
require_once './db-config.php';
use Illuminate\Database\Capsule\Manager as Capsule;

use Telegram\Bot\Api;

$client = new Api('5985602812:AAFRbavRYfe0q-XHFQC9-1X7isImb7AG20Q');

$last_update_id = 0;

while (true) {

    $response = $client->getUpdates(['offset' => $last_update_id, 'timeout' => 5]);

    if (count($response) <= 0) continue;

    foreach ($response as $r) {

        $last_update_id = $r->getUpdateId() + 1;
        $message = $r->getMessage();

        $username = $message->getChat()->getUsername();
        $command = $message->getText();
        $chatId = $message->getChat()->getId();

        $arr = Command($message->getText());
        $text = $arr["text"];
        $photo = $arr["photo"];

        InsertRecord($username, $chatId, $command, $text);

        $response = $client->sendPhoto([
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $text
        ]);
    }
}

function Command($comando)
{
    switch ($comando) {
        case "/start":
            return GetStarted();
            break;
        case "/meme":
            return GetMemed();
            break;
        case "/anime":
            return GetAnime();
            break;
        case "/maniglio":
            return array("photo" => "./ph/maniglio.jpg", "text" => "kebab ordinato de pefforza");
            break;
        case "/costa":
            return array("photo" => "./ph/costa.jpg", "text" => "il più grande hacker di tutti i tempi");
            break;
        case "/simp":
            return array("photo" => "./ph/gheller.jpg", "text" => "il signore del puzzo");
            break;
        case "/rappresentante":
            return array("photo" => "./ph/chiara.jpg", "text" => "salutala perchè non la vedrai mai più");
            break;
        case "/trio":
            return array("photo" => "./ph/trio.jpg", "text" => "il triumvirato");
            break;
        default:
            return "Comando non riconosciuto, prova con /start";
            break;
    }
}

function GetStarted()
{
    return array("photo" => "./ph/dario.png", "text" => "Comandi disponibili\n/start per comprendere\n/anime per conoscere\n/meme per l'allegrezza");
}

function GetMemed()
{
    return array("photo" => "./ph/dario.png", "text" => "Comandi disponibili\n/start per comprendere\n/maniglio per ordinare un kebabon\n/costa per hackerare i server del MC Donald\n/simp per simpare\n/trio per scatenare l'apocalisse\n/rappresentante per andare fuori aula");
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

function InsertRecord($username, $chatId, $command, $reply){

    if (!Capsule::schema()->hasTable('records')) {

        Capsule::schema()->create('records', function ($table) {
    
            $table->increments('id');
    
            $table->string('username');
    
            $table->string('chatId');
    
            $table->string('command');

            $table->string('reply');

            $table->timestamps();
    
        });
    
    }
    
    Capsule::table('records')->insert([
    
        'username' => $username,
        'chatId' => $chatId,
        'command' => $command,
        'reply' => $reply
    ]);
}