<?php


namespace MicrosoftAzure\Storage\Samples;

// require __DIR__."/vendor/autoload.php";
require_once "vendor/autoload.php";

use MicrosoftAzure\Storage\Common\ServicesBuilder;
// use MicrosoftAzure\Storage\Common\ServiceException;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

class Storage {

  protected $connectionString;
  protected $tableClient;

  public function __construct()
  {
    // $connectionString = 'DefaultEndpointsProtocol=https;AccountName=roundplatform;AccountKey=4TIBx0yc648KFnuMsLjXMoT/IqFfCW3/X5ZhzifcKBEydn5qxYY2741M9krgp7wDu2JW1/AD1PyCMspywUYKuw==;EndpointSuffix=core.windows.net';
    $this->connectionString = 'DefaultEndpointsProtocol=https;AccountName=roundplatform;AccountKey=GEodu+9psNmilnxS1Kj+XMkUiVPrQ4I+uAbQGi72gms1bq85lchsRMhw2587bairl2II9lULG+8fKrs/fZQ5eQ==';
    $this->tableClient = ServicesBuilder::getInstance()->createTableService($connectionString);
  }

  public function getCurrentShopCredit($partitionkey) {
    $filter = "PartitionKey eq '".$partitionKey."'";

    try    {
        $result = $tableClient->queryEntities("RPxShopCreditData", $filter);
    }
    catch(ServiceException $e){
        // Handle exception based on error codes and messages.
        // Error codes and messages are here:
        // http://msdn.microsoft.com/library/azure/dd179438.aspx
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message."<br />";
    }

    $entities = $result->getEntities();

    // foreach($entities as $entity){
    //     echo $entity->getPartitionKey().":".$entity->getRowKey()."<br />";
    // }

    return $entities[0]->getPartitionKey();
  }
}

$storage = new Storage;

$pk = $_GET['partitionkey'];

echo $storage->getCurrentShopCredit($pk);

?>
