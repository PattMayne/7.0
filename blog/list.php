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
$filteredCount = count($filteredFiles); // probably delete this... I'm not using it.

// Get filenames only
$filteredFileNames = array_map('basename', $filteredFiles);

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

    $linkElement = '<a class="blog_link" href="' . $linkURL . '">' . $article_title . '</a><span class="blog_link_cats"> [ ' . $article_categories . ' ]</span><br/>';

    echo $linkElement;

}


?>