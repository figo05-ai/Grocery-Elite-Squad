<?php

// Fix Resources Namespaces
$resourceDirs = [
    'app/Http/Resources/Support',
    'app/Http/Resources/System',
    'app/Http/Resources/User',
    'app/Http/Resources/Order',
    'app/Http/Resources/Catalog',
];

function fixNamespacesInDir($dir, $prefix)
{
    if (! is_dir($dir)) {
        return;
    }
    foreach (scandir($dir) as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = "$dir/$item";
        if (is_dir($path)) {
            fixNamespacesInDir($path, "$prefix\\$item");
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $content = file_get_contents($path);
            $newNs = "namespace $prefix;";
            // Replace any existing namespace with the correct one
            $content = preg_replace('/namespace\s+[^;]+;/', $newNs, $content);
            file_put_contents($path, $content);
        }
    }
}

foreach ($resourceDirs as $dir) {
    if (! is_dir(__DIR__.'/../'.$dir)) {
        continue;
    }
    $parts = explode('/', $dir);
    $domain = end($parts);
    fixNamespacesInDir(__DIR__.'/../'.$dir, "App\\Http\\Resources\\$domain");
}

// Move lingering Support rules if any
$supportRules = [
    'EgyptianPhoneRules.php' => ['Rules\User\EgyptianPhoneRule\EgyptianPhoneRule', 'EgyptianPhoneRule'],
    'EmailValidation.php' => ['Rules\User\EmailValidation\EmailValidation', 'EmailValidation'],
];
foreach ($supportRules as $file => $info) {
    $oldPath = __DIR__.'/../app/Support/'.$file;
    if (file_exists($oldPath)) {
        $parts = explode('\\', $info[0]);
        $className = array_pop($parts);
        $ns = 'App\\'.implode('\\', $parts);
        $newDir = __DIR__.'/../app/'.str_replace('\\', '/', implode('\\', $parts));
        if (! is_dir($newDir)) {
            mkdir($newDir, 0755, true);
        }

        $content = file_get_contents($oldPath);
        $content = preg_replace('/namespace\s+[^;]+;/', "namespace $ns;", $content);
        $content = preg_replace('/class\s+'.basename($file, '.php').'/', "class $className", $content);

        file_put_contents("$newDir/$className.php", $content);
        unlink($oldPath);
    }
}
echo "Fixed.\n";
