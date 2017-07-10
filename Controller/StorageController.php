<?php

// namespace MicrosoftAzure\Storage\Samples;
namespace Controller;

// require __DIR__."/vendor/autoload.php";
require_once "vendor/autoload.php";

use MicrosoftAzure\Storage\Common\ServicesBuilder;
// use MicrosoftAzure\Storage\Common\ServiceException;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Table\Models\Entity;
use MicrosoftAzure\Storage\Table\Models\EdmType;

class StorageController {

  protected $connectionString;
  protected $tableClient;

  public function __construct()
  {
    // $connectionString = 'DefaultEndpointsProtocol=https;AccountName=roundplatform;AccountKey=4TIBx0yc648KFnuMsLjXMoT/IqFfCW3/X5ZhzifcKBEydn5qxYY2741M9krgp7wDu2JW1/AD1PyCMspywUYKuw==;EndpointSuffix=core.windows.net';
    $this->connectionString = 'DefaultEndpointsProtocol=https;AccountName=roundplatform;AccountKey=GEodu+9psNmilnxS1Kj+XMkUiVPrQ4I+uAbQGi72gms1bq85lchsRMhw2587bairl2II9lULG+8fKrs/fZQ5eQ==';
    $this->tableClient = ServicesBuilder::getInstance()->createTableService($this->connectionString);
  }

  public function getCurrentShopCredit($partitionkey) {
    $filter = "PartitionKey eq '".$partitionkey."'";

    try    {
        $result = $this->tableClient->queryEntities("RPxShopCreditData", $filter);
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

    return $entities[0]->getPropertyValue("NewBalance");
  }

  public function topupShop($shopId, $amount) {
    $oldBalance = $this->getCurrentShopCredit($shopId);
    $newBalance = intval($oldBalance) + intval($amount);
    $rowKey = $this->getKeyTime();
    $entity = new Entity();
    $entity->setPartitionKey($shopId);
    $entity->setRowKey($rowKey);
    $entity->addProperty("NewBalance", EdmType::INT32, $newBalance);
    $entity->addProperty("OldBalance", EdmType::INT32, $oldBalance);
    $entity->addProperty("Operation", EdmType::STRING, "เติมเครดิต");
    $entity->addProperty("ActionCredit", EdmType::INT32, 1);
    try {
        $this->tableClient->insertEntity("RPxShopCreditData", $entity);
        return true;
    } catch (ServiceException $e) {
        $code = $e->getCode();
        $error_message = $e->getMessage();
        echo $code.": ".$error_message.PHP_EOL;
        return false;
    }
  }

  protected function getKeyTime() {
    $limit_date = new DateTime("2999-1-1 00:00:00");
    $diff = (float) $limit_date->getTimeStamp()*10000 - microtime(true)*10000;
    return number_format($diff,0,"","") . "0";
  }


}

?>
