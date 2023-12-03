<?php
function breakingRecords($scores)
{
    $highest = current($scores);
    $lowest = current($scores);

    $breakMax = 0;
    $breakMin = 0;

    foreach ($scores as $score) {
        if ($score < $lowest) {
            $lowest = $score;
            $breakMin += 1;
        } elseif ($score > $highest) {
            $highest = $score;
            $breakMax += 1;
        }
    }


    return [$breakMax, $breakMin];
}

print_r(breakingRecords([10, 5, 20, 20, 4, 5, 2, 25, 1]));
