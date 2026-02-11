<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secure Tokenized Video Streaming with Artplayer</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
    font-family: Arial, sans-serif;
    max-width: 900px;
    margin: auto;
    padding: 40px 20px;
    line-height: 1.6;
    background: #0f172a;
    color: #f1f5f9;
}
h1, h2, h3 {
    color: #38bdf8;
}
code {
    background: #1e293b;
    padding: 3px 6px;
    border-radius: 5px;
    font-size: 14px;
}
pre {
    background: #1e293b;
    padding: 15px;
    overflow-x: auto;
    border-radius: 8px;
}
a {
    color: #38bdf8;
}
.section {
    margin-bottom: 40px;
}
.badge {
    display: inline-block;
    padding: 6px 12px;
    background: #22d3ee;
    color: #000;
    border-radius: 20px;
    font-size: 12px;
    margin-right: 8px;
}
</style>
</head>
<body>

<h1>Secure Token-Based Video Streaming with Artplayer</h1>

<p>
A secure, tokenized video streaming system built with <strong>PHP + Apache + Artplayer</strong>.
Direct video access is blocked and all video requests are validated using time-based HMAC tokens.
</p>

<div class="section">
<h2>Features</h2>

<ul>
<li>Token-based secure streaming</li>
<li>Time-limited access (configurable expiry)</li>
<li>Hidden direct MP4 URLs</li>
<li>HTTP Range support (seeking works)</li>
<li>Responsive fullscreen Artplayer UI</li>
<li>Customizable VIP Glass-style design</li>
<li>Right-click menu disabled</li>
</ul>
</div>

<div class="section">
<h2>System Architecture</h2>

<ol>
<li>User opens: <code>example.com/movie.mp4</code></li>
<li>Apache redirects to <code>generate.php</code></li>
<li>Token + expiry generated</li>
<li>Redirect to <code>player.php</code></li>
<li>Artplayer loads secure stream from <code>stream.php</code></li>
<li>Stream validated and delivered with byte-range support</li>
</ol>
</div>

<div class="section">
<h2>File Structure</h2>

<pre>
/generate.php
/player.php
/stream.php
/.htaccess
/movie.mp4
</pre>
</div>

<div class="section">
<h2>.htaccess Rule</h2>

<pre>
RewriteEngine On

RewriteCond %{REQUEST_URI} \.mp4$ [NC]
RewriteCond %{QUERY_STRING} !token=
RewriteRule ^(.*\.mp4)$ /generate.php?file=$1 [L]
</pre>

</div>

<div class="section">
<h2>Token Expiry Configuration</h2>

<p>In <code>generate.php</code>:</p>

<pre>
$expires = time() + 3600; // 1 hour
</pre>

<p>Change the value to adjust validity:</p>

<ul>
<li>1800 = 30 minutes</li>
<li>3600 = 1 hour</li>
<li>86400 = 24 hours</li>
</ul>

</div>

<div class="section">
<h2>Security Notes</h2>

<ul>
<li>Keep the <code>$secret</code> value identical across all PHP files</li>
<li>Use a strong random secret key</li>
<li>Shorter expiry = higher security</li>
<li>Ensure Apache has PHP enabled</li>
<li>File permissions should be 644</li>
</ul>

</div>

<div class="section">
<h2>Requirements</h2>

<ul>
<li>Apache (mod_rewrite enabled)</li>
<li>PHP 7.4+</li>
<li>Artplayer (CDN version used)</li>
<li>Linux-based VPS recommended</li>
</ul>

</div>

<div class="section">
<h2>Optional Enhancements</h2>

<ul>
<li>IP-bound tokens</li>
<li>Single-use tokens</li>
<li>Auto token refresh</li>
<li>User watermark overlay</li>
<li>Cloudflare integration</li>
</ul>

</div>

<hr>

<p>
Developed for secure self-hosted video streaming with modern UI and protection.
</p>

</body>
</html>
