<?php

require_once("Controller/BotController.php");

use Controller\BotController;

$body = file_get_contents("php://input");

$bot = new BotController();

$bot->parseEvent($body);
?>
