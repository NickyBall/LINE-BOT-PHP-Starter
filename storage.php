<?php

namespace MicrosoftAzure\Storage\Samples;

require __DIR__."/vendor/autoload.php";

use MicrosoftAzure\Storage\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\ServiceException;


$connectionString = 'DefaultEndpointsProtocol=https;AccountName=roundplatform;AccountKey=4TIBx0yc648KFnuMsLjXMoT/IqFfCW3/X5ZhzifcKBEydn5qxYY2741M9krgp7wDu2JW1/AD1PyCMspywUYKuw==;EndpointSuffix=core.windows.net';
$tableClient = ServicesBuilder::getInstance()->createTableService($connectionString);

$filter = "PartitionKey eq '3097272744648780' and RowKey eq '3097272744648580'";

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

foreach($entities as $entity){
    echo $entity->getPartitionKey().":".$entity->getRowKey()."<br />";
}

?>
