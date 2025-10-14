<?php

function reverse_string($string) {
    $high_index = strlen($string) - 1;
    $low_index = 0;

    while ($high_index > $low_index) {
        $top_char = $string[$high_index];
        $string[$high_index] = $string[$low_index];
        $string[$low_index] = $top_char;

        $high_index -= 1;
        $low_index += 1;
    }

    return $string;
}

// Set up the randomness generator for the whole  script
$floor_time = floor(time()) * 6;
$floor_time = (string) $floor_time;
$floor_time = reverse_string($floor_time);
$floor_time = (int) $floor_time;

srand($floor_time);


// This was cool but I decided not to use it. But it's cool so I'm keeping it.
// randomly pick a side and give it a 5px black border.
function inject_thicker_border() {
    $sides = array(
        "top",
        "bottom",
        "right",
        "left");
    $side_index = rand(0, count($sides) - 1);
    $html = ' style="border-' . $sides[$side_index] . ': 5px solid black;" ';
    return $html;
}

  
?>