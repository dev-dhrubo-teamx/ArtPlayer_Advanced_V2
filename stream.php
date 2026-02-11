<?php
// =========================
// CONFIG
// =========================
$secret = "YOUR_SECRET_KEY"; // SAME secret as generate.php & player.php


// =========================
// GET PARAMS
// =========================
$file    = $_GET['file']    ?? '';
$expires = $_GET['expires'] ?? '';
$token   = $_GET['token']   ?? '';

if (!$file || !$expires || !$token) {
    http_response_code(403);
    exit('Invalid request');
}

if ($expires < time()) {
    http_response_code(403);
    exit('Link expired');
}

$validToken = hash_hmac('sha256', $file . $expires, $secret);

if (!hash_equals($validToken, $token)) {
    http_response_code(403);
    exit('Invalid token');
}


// =========================
// SECURE FILE PATH
// =========================
$baseDir = realpath($_SERVER['DOCUMENT_ROOT']);
$fullPath = realpath($baseDir . '/' . $file);

if (!$fullPath || strpos($fullPath, $baseDir) !== 0 || !file_exists($fullPath)) {
    http_response_code(404);
    exit('File not found');
}


// =========================
// VIDEO STREAMING
// =========================
$size  = filesize($fullPath);
$start = 0;
$end   = $size - 1;

header('Content-Type: video/mp4');
header('Accept-Ranges: bytes');

if (isset($_SERVER['HTTP_RANGE'])) {

    if (preg_match('/bytes=(\d+)-(\d*)/', $_SERVER['HTTP_RANGE'], $matches)) {

        $start = intval($matches[1]);

        if (!empty($matches[2])) {
            $end = intval($matches[2]);
        }

        if ($end > $size - 1) {
            $end = $size - 1;
        }

        if ($start > $end) {
            http_response_code(416);
            exit;
        }

        header("HTTP/1.1 206 Partial Content");
        header("Content-Range: bytes $start-$end/$size");
    }
}

$length = $end - $start + 1;
header("Content-Length: $length");

$fp = fopen($fullPath, 'rb');
fseek($fp, $start);

$buffer = 8192;

while (!feof($fp) && ($pos = ftell($fp)) <= $end) {
    if ($pos + $buffer > $end) {
        $buffer = $end - $pos + 1;
    }
    echo fread($fp, $buffer);
    flush();
}

fclose($fp);
exit;
