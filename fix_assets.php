<?php

$dirs = [
    'c:\\xampp\\htdocs\\laravel\\services\\resources\\views\\website',
    'c:\\xampp\\htdocs\\laravel\\services\\resources\\views\\partials\\website'
];

function processFiles($dir) {
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $f) {
        if ($f == '.' || $f == '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $f;
        if (is_dir($path)) {
            processFiles($path);
        } elseif (preg_match('/\.blade\.php$/', $path)) {
            $content = file_get_contents($path);

            $original = $content;

            // Replace "../assets/img" with "{{ asset('website/assets/img') }}"
            $content = preg_replace('/src="\.\.\/assets\/img\/(.*?)"/', 'src="{{ asset(\'website/assets/img/$1\') }}"', $content);
            $content = preg_replace('/data-src="\.\.\/assets\/img\/(.*?)"/', 'data-src="{{ asset(\'website/assets/img/$1\') }}"', $content);
            $content = preg_replace('/data-src="assets\/img\/(.*?)"/', 'data-src="{{ asset(\'website/assets/img/$1\') }}"', $content);
            // Replace css links
            $content = preg_replace('/href="assets\/css\/(.*?)"/', 'href="{{ asset(\'website/assets/css/$1\') }}"', $content);

            // Replace exact page references for routing (but ignore those that already have {{ url(...) }})
            // We use negative lookbehind to ensure we don't double replace. But PHP PCRE regex allows this easily:
            // Matches href="something.html"
            $content = preg_replace('/href="index\.html"/', 'href="{{ url(\'/\') }}"', $content);
            $content = preg_replace('/href="([a-zA-Z0-9\-]+)\.html"/', 'href="{{ url(\'/$1\') }}"', $content);

            if ($content !== $original) {
                file_put_contents($path, $content);
                echo "Updated: $path\n";
            }
        }
    }
}

foreach ($dirs as $d) {
    processFiles($d);
}
echo "Done!\n";
