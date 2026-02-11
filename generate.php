<?php
$secret = "YOUR_SECRET_KEY";

$file = $_GET['file'];
$expires = time() + 3600;
$token = hash_hmac('sha256', $file.$expires, $secret);

header("Location: /player.php?file=$file&expires=$expires&token=$token");
exit;
