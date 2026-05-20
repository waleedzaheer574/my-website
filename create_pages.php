<?php

$headerFile = 'c:\\xampp\\htdocs\\laravel\\services\\resources\\views\\partials\\website\\header.blade.php';
if (file_exists($headerFile)) {
    $content = file_get_contents($headerFile);
    // Replace href="something.html" with href="{{ url('/something') }}"
    $content = preg_replace('/href="([a-zA-Z0-9\-]+)\.html"/', 'href="{{ url(\'/$1\') }}"', $content);
    file_put_contents($headerFile, $content);
}

$viewsDir = 'c:\\xampp\\htdocs\\laravel\\services\\resources\\views\\website';
$pages = [
    'service', 'service-details', 'contact', 'portfolio', 'portfolio-details',
    'coming-soon', 'blog', 'blog-details', 'blog-details-2', 'blog-details-3'
];

foreach ($pages as $page) {
    $filePath = $viewsDir . DIRECTORY_SEPARATOR . $page . '.blade.php';
    if (!file_exists($filePath)) {
        $ucPage = ucwords(str_replace('-', ' ', $page));
        $bladeContent = "@extends('layouts.website')\n\n@section('content')\n<div class=\"cs-height_140 cs-height_lg_80\"></div>\n<div class=\"container\">\n  <h1>{$ucPage}</h1>\n</div>\n<div class=\"cs-height_140 cs-height_lg_80\"></div>\n@endsection\n";
        file_put_contents($filePath, $bladeContent);
        echo "Created view: $page.blade.php\n";
    }
}
