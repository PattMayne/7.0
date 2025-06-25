<?php

$folderPath = 'posts';
$domain = $_SERVER['HTTP_HOST'];

// Get all PHP files
$phpFiles = glob($folderPath . DIRECTORY_SEPARATOR . '*.php');

// Filter out 'template.php'
$filteredFiles = array_filter($phpFiles, function($file) use ($folderPath) {
    // Get just the filename
    $fileName = basename($file);
    // Exclude 'template.php'
    return strtolower($fileName) !== 'template.php';
});

// Count the files
$filteredCount = count($filteredFiles);

// Get filenames only
$filteredFileNames = array_map('basename', $filteredFiles);

// echo "Number of PHP files (excluding 'example.php'): " . $filteredCount . "\n";
// echo "File names:\n";

$titlesAndFilenames = array();

foreach ($filteredFileNames as $fileName) {

    $pathAndFilename = 'posts/'. $fileName;
    $article_html = file_get_contents($pathAndFilename);
    $doc = new DOMDocument();
    $doc->loadHTML($article_html);
    libxml_clear_errors();

    $article_title = $doc->getElementById('article_title')->nodeValue; // nodeValue ONLY retrieves text (clears all tags)
    $article_categories = $doc->getElementById('categories')->nodeValue;

    $filenameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
    $linkURL = '/blog/post.php?slug=' . $filenameWithoutExt;

    $linkElement = '<a class="blog_link" target="_blank" href="' . $linkURL . '">' . $article_title . '</a><br/>';

    echo $linkElement;

}


?>