<?php

namespace Controller;

class BotController {

  define("LINE_MESSAGING_API_CHANNEL_SECRET", 'a0f51fe1778dbb3a68f7774658ecedab');
  define("LINE_MESSAGING_API_CHANNEL_TOKEN", 'Vi4bbR+WBZQcF2HtY3T2YEsH9Y9Ub/c3rVM3E/9M+0C7uIDyLw0YhApZ81FHlBb+9zUHgXeY7SfUIxA+3aA5h57ldvi++ux2wvb/vfHOZ/3wTJJOC+SRNWcOT48iIfdrWFKLQw58geBBbRdZ0ND9tQdB04t89/1O/w1cDnyilFU=');

  require __DIR__."../vendor/autoload.php";

  protected $httpClient;
  protected $bot;
  protected $signature;
  protected $body;

  public function __construct() {
    $this->httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(LINE_MESSAGING_API_CHANNEL_TOKEN);
    $this->bot = new \LINE\LINEBot($this->httpClient, ['channelSecret' => LINE_MESSAGING_API_CHANNEL_SECRET]);

    $this->signature = $_SERVER["HTTP_".\LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
  }

  protected function parseEvent($body) {
    $events = $this->bot->parseEventRequest($body, $this->signature);

    foreach ($events as $event) {
        if ($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage) {
            $reply_token = $event->getReplyToken();
            $text = $event->getText();
            $bot->replyText($reply_token, $text);
        }
    }

  }

}

?>