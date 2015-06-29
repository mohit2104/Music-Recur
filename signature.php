<?php
$secret;
include('../aws_config.php');
$t=time();
$policy = '{"expiration": "'.date("Y-m-d",$t). "T". date("H:i:s",strtotime("+10 minutes", $t)) . "Z".'",
  "conditions": [
    {"bucket": "musicrecur"},
    ["starts-with", "$key", "songs/"],
    {"acl": "public-read"},
    {"success_action_redirect": "http://www.goyalm.in/music/v2.php"},
    ["starts-with", "$Content-Type", "audio/mp3"],
    ["content-length-range", 0, 10000000]
  ]
}
';

$pl = base64_encode($policy);
$signature = base64_encode(hash_hmac('sha1', $pl, $secret, true));
echo '{ "pl" : "'.$pl.'", "sig" : "'.$signature.'" }';
?>