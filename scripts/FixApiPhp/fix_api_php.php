<?php

$file = __DIR__.'/../routes/api.php';
$content = file_get_contents($file);

// Find <?php
$pos = strpos($content, '<?php');
if ($pos !== false && $pos > 0) {
    $before = trim(substr($content, 0, $pos));
    $after = substr($content, $pos + 5);

    // Check if $before contains use statements
    if (strpos($before, 'use ') !== false) {
        $content = "<?php\n".$before."\n".$after;
        file_put_contents($file, $content);
        echo "Fixed api.php\n";
    }
}
