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

        $text = "text";
        $text = Command($message->getText());

        $response = $client->sendMessage([
            'chat_id' => $chatId,
            'text' => $text
        ]);
    }
}

function Command($comando)
{
    switch ($comando) {
        case "/start":
            return "Comandi disponibili\n/start per comprendere\n/simp per la verità\n/sivaaletto per andare a letto\n/maniglio per ordinare un kebabon\n";
            break;
        case "/simp":
            return "Joey Gheller";
            break;
        case "/sivaaletto?":
            return "de pefforza";
            break;
        case "/maniglio":
            return "il più forte";
            InsertRecord();
            break;
        default:
            return "qualcosa è andato storto";
            break;
    }
}

function InsertRecord()
{
    require_once("./db-queries.php");
    Insert("A", "a", 123, "a", "a");
}