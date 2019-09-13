<?php
const COLUMN_MAX = 10;
const ROW_MAX = 10;
$maxlenght = mb_strlen(COLUMN_MAX*ROW_MAX)+1;
for ($i = 1; $i <= COLUMN_MAX; ++$i) {
    for ($j = 1; $j <= ROW_MAX; ++$j) {
        echo str_pad($i * $j,$maxlenght," ", STR_PAD_LEFT);
    }
    echo PHP_EOL;
}
