<?php

$baseDirs = [
    __DIR__.'/../app/Http/Requests',
    __DIR__.'/../app/Models',
    __DIR__.'/../app/Exceptions',
    __DIR__.'/../app/Jobs',
    __DIR__.'/../app/Mail',
    __DIR__.'/../app/Notifications',
    __DIR__.'/../app/Observers',
    __DIR__.'/../app/Rules',
    __DIR__.'/../app/Services',
    __DIR__.'/../app/Traits',
    __DIR__.'/../app/Providers',
    __DIR__.'/../app/Http/Controllers',
];

foreach ($baseDirs as $dir) {
    if (! is_dir($dir)) {
        continue;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    $filesToMove = [];
    foreach ($iterator as $item) {
        if ($item->isFile() && $item->getExtension() === 'php') {
            $path = $item->getPathname();

            // Skip files already in a folder with their own name (or similar strict structures)
            // A file is considered in its own folder if its parent folder name matches the file basename
            $basename = $item->getBasename('.php');
            $parentName = basename($item->getPath());

            if ($parentName === $basename) {
                continue;
            }

            // Skip Controller base class
            if ($basename === 'Controller' && $parentName === 'Controllers') {
                continue;
            }

            $filesToMove[] = [
                'path' => $path,
                'basename' => $basename,
                'dir' => $item->getPath(),
            ];
        }
    }

    // Move files
    foreach ($filesToMove as $fileInfo) {
        $newDir = $fileInfo['dir'].'/'.$fileInfo['basename'];
        if (! is_dir($newDir)) {
            mkdir($newDir, 0755, true);
        }

        $newPath = $newDir.'/'.$fileInfo['basename'].'.php';

        // Update namespace in the file
        $content = file_get_contents($fileInfo['path']);

        // Find current namespace
        if (preg_match('/namespace\s+([^;]+);/', $content, $matches)) {
            $oldNamespace = $matches[1];
            $newNamespace = $oldNamespace.'\\'.$fileInfo['basename'];

            $content = preg_replace(
                '/namespace\s+'.preg_quote($oldNamespace, '/').';/',
                "namespace $newNamespace;",
                $content
            );

            // Write to new path
            file_put_contents($newPath, $content);
            unlink($fileInfo['path']);

            // Note: This script just moves files and updates their internal namespace.
            // A full AST parser would be needed to update all references across the app.
        }
    }
}

echo "One file = one folder rule applied mechanically to remaining classes.\n";
