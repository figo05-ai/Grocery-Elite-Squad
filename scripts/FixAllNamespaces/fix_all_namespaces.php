<?php

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__.'/../app'));

foreach ($iterator as $file) {
    if ($file->isDir()) {
        continue;
    }
    if ($file->getExtension() !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    // Normalize path separators
    $path = str_replace('\\', '/', $path);

    // Extract the relative path from 'app/'
    if (preg_match('/\/app\/(.+)\/[^\/]+\.php$/', $path, $matches)) {
        $relativeDir = $matches[1];

        // Convert to namespace
        $namespace = 'App\\'.str_replace('/', '\\', $relativeDir);

        $content = file_get_contents($path);

        // Replace namespace if it doesn't match
        $pattern = '/namespace\s+[A-Za-z0-9_\\\\]+\s*;/';
        if (preg_match($pattern, $content, $nsMatch)) {
            $currentNs = trim(str_replace(['namespace', ';'], '', $nsMatch[0]));
            if ($currentNs !== $namespace) {
                $content = preg_replace($pattern, "namespace $namespace;", $content);
                file_put_contents($path, $content);
                echo "Fixed namespace in: $path to $namespace\n";
            }
        } else {
            // No namespace found, maybe we should add it? Or ignore. Usually it's there.
        }
    } elseif (preg_match('/\/app\/[^\/]+\.php$/', $path, $matches)) {
        // Root app folder
        $namespace = 'App';
        $content = file_get_contents($path);
        $pattern = '/namespace\s+[A-Za-z0-9_\\\\]+\s*;/';
        if (preg_match($pattern, $content, $nsMatch)) {
            $currentNs = trim(str_replace(['namespace', ';'], '', $nsMatch[0]));
            if ($currentNs !== $namespace) {
                $content = preg_replace($pattern, "namespace $namespace;", $content);
                file_put_contents($path, $content);
                echo "Fixed namespace in: $path to $namespace\n";
            }
        }
    }
}

echo "All namespaces fixed.\n";
