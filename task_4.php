<?php

/* 4. Дан массив из 100 элементов. Требуется вывести количество последовательных пар одинаковых элементов
Например: 1, 1, 2, 3, 4 -51, 12, 12, 12, -51
Пришлите ссылку на репозиторий с решением */

$array = [1, 1, 2, 3, 4, -51, 12, 12, 12, -51, 12, 12, 34, 34, 34, 43, 34];
$sum = 0;

// с использованием конструкции while
$i = 0;
$count = count($array) - 1;
while ($i < $count) {
    if ($array[$i] == $array[$i + 1]) {
        $sum++;
    }
    $i++;
}

// с использованием конструкции do-while
/* $i = 0;
$count = count($array) - 1;
do {
    if ($array[$i] == $array[$i + 1]) {
        $sum++;
    }
    $i++;
} while ($i < $count); */

// с использованием конструкции for
/* $count = count($array) - 1;
for ($i = 0; $i < $count; $i++) {
    if ($array[$i] == $array[$i + 1]) {
        $sum++;
    }
} */

// с использованием конструкции foreach
/* foreach ($array as $key => $value) {
    if (array_key_exists(($key + 1), $array)) {
        if ($array[$key] == $array[$key + 1]) {
            $sum++;
        }
    } else {
        break;
    }
} */

echo "Количество последовательных пар одинаковых элементов: $sum";
