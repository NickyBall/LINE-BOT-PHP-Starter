<?php

namespace Service;

class ShareService {

  public static function log($msg) {
    file_put_contents("php://stdout", $msg);
  }

}

?>
