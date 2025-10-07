<?php


$$endungen = file("filme.txt");

echo $$endungen[1];

exit;


$zaehle = array_count_values ($endungen);

while ( list ( $key, $val ) = each ( $zaehle ) )
{
    echo "$key" . " kommt " . "$val" . " mal vor"."\n";
    $i++;
}

echo "\n";

echo $i;


?>


