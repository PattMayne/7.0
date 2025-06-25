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

$filenamesAndCategoties = array();

// Build the array of link-data objects.
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

    $filenamesAndCategoties[] = [
        'url' => $linkURL,
        'title' => $article_title,
        'categories' => $article_categories,
        'filename' => $fileName
    ];


}


// SORT by DATE (which should be prefixed in the filename)
usort($filenamesAndCategoties, function ($b, $a) {
    return strcmp($a['filename'], $b['filename']);
});

foreach( $filenamesAndCategoties as $unit) {
    //echo ''. $unit['url'] .'<br/>';

    $linkElement = '<a class="blog_link" href="' . $unit['url'] . '">' . $unit['title'] . '</a><span class="blog_link_cats"> [ ' . $unit['categories'] . ' ]</span><br/>';

    echo $linkElement;
}


?>