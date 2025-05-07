<?php
/**
 * Extended scan: Dumps core theme files + all custom inc/ + src/sass/ files
 * from understrap-child into one file.
 */

$outputFile = 'theme-file-dump.txt';
file_put_contents($outputFile, ''); // Reset the file

$baseDirs = [
    'themes/understrap'        => ['header.php', 'footer.php', 'page.php'],
    'themes/understrap-child'  => ['header.php', 'footer.php'] // Exclude missing page.php
];

// Function to write file contents to output
function appendFileDump($title, $path, $outputFile) {
    if (file_exists($path)) {
        file_put_contents($outputFile, PHP_EOL . str_repeat("=", 64) . PHP_EOL, FILE_APPEND);
        file_put_contents($outputFile, " File: $title" . PHP_EOL, FILE_APPEND);
        file_put_contents($outputFile, str_repeat("=", 64) . PHP_EOL, FILE_APPEND);
        file_put_contents($outputFile, file_get_contents($path) . PHP_EOL, FILE_APPEND);
    } else {
        file_put_contents($outputFile, "❌ File not found: $path" . PHP_EOL, FILE_APPEND);
    }
}

// 1. Scan main theme files
foreach ($baseDirs as $dir => $files) {
    file_put_contents($outputFile, PHP_EOL . str_repeat("=", 64) . PHP_EOL, FILE_APPEND);
    file_put_contents($outputFile, " Scanning Theme Directory: $dir" . PHP_EOL, FILE_APPEND);
    file_put_contents($outputFile, str_repeat("=", 64) . PHP_EOL, FILE_APPEND);

    foreach ($files as $file) {
        appendFileDump($file, $dir . '/' . $file, $outputFile);
    }
}

// 2. Scan all PHP files in understrap-child/inc
$incDir = 'themes/understrap-child/inc';
if (is_dir($incDir)) {
    $incFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($incDir));
    foreach ($incFiles as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $relativePath = str_replace('\\', '/', $file->getPathname());
            appendFileDump("inc/" . basename($relativePath), $relativePath, $outputFile);
        }
    }
}

// 3. Scan all SCSS files in understrap-child/src/sass
$sassDir = 'themes/understrap-child/src/sass';
if (is_dir($sassDir)) {
    $sassFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($sassDir));
    foreach ($sassFiles as $file) {
        if ($file->isFile() && in_array($file->getExtension(), ['scss', 'sass'])) {
            $relativePath = str_replace('\\', '/', $file->getPathname());
            appendFileDump("sass/" . basename($relativePath), $relativePath, $outputFile);
        }
    }
}

echo "✅ Theme and custom folders dumped to $outputFile" . PHP_EOL;
