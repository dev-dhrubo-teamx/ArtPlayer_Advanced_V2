<?php
$secret = "YOUR_SECRET_KEY";

$file = $_GET['file'];
$expires = $_GET['expires'];
$token = $_GET['token'];

$valid = hash_hmac('sha256', $file.$expires, $secret);
if (!hash_equals($valid, $token) || $expires < time()) {
    die("Invalid");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>VIP Player</title>

<style>
html,body{
    margin:0;
    padding:0;
    height:100%;
    background:#000;
}
#player{
    width:100%;
    height:100%;
}
</style>
</head>
<body>

<div id="player"></div>

<script src="https://unpkg.com/artplayer/dist/artplayer.js"></script>

<script>
new Artplayer({
    container: '#player',
    url: '/stream.php?file=<?php echo urlencode($file); ?>&expires=<?php echo $expires; ?>&token=<?php echo $token; ?>',
    autoplay: true,
    fullscreen: true,
    autoSize: true,
    theme: '#00ffe7',
    contextmenu: [],
});
</script>

</body>
</html>
