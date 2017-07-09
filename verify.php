<?php
$access_token = "Vi4bbR+WBZQcF2HtY3T2YEsH9Y9Ub/c3rVM3E/9M+0C7uIDyLw0YhApZ81FHlBb+9zUHgXeY7SfUIxA+3aA5h57ldvi++ux2wvb/vfHOZ/3wTJJOC+SRNWcOT48iIfdrWFKLQw58geBBbRdZ0ND9tQdB04t89/1O/w1cDnyilFU=";

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
?>
