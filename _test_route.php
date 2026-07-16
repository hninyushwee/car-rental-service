<?php
chdir("C:\Users\hp\Documents\Portfolio\car-rental-service");
require 'C:\Users\hp\Documents\Portfolio\car-rental-service\vendor\autoload.php';
$app = require 'C:\Users\hp\Documents\Portfolio\car-rental-service\bootstrap\app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
try {
    $request = Illuminate\Http\Request::create('/admin/deposit-settings', 'GET');
    $response = $kernel->handle($request);
    echo 'Status: '.$response->getStatusCode();
    echo "\n";
    $content = $response->getContent();
    if (str_contains($content, '404') || str_contains($content, 'Page Not Found') || $response->getStatusCode() === 404) {
        echo 'GOT 404!'."\n";
    } else {
        echo 'OK - page rendered successfully'."\n";
    }
} catch(Exception $e) {
    echo 'Error: '.$e->getMessage();
}
