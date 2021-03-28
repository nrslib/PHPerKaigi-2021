<?php

function map(array $array, callable $predicate)
{
    return foldRight([], $array, function ($a, $acc) use ($predicate) {
        array_unshift($acc, $predicate($a));
        return $acc;
    });
}

function foldRight($acc, array $elements, callable $f)
{
    // 先頭を取得する
    $head = count($elements) > 0 ? $elements[0] : null;

    return match (true) {
        $head === null => $acc,
        default => $f($head, foldRight($acc, array_slice($elements, 1), $f)) // 後半の array_slice は先頭以外を取得している（PHP だとリソースをかなり使いそうなので実用性は……）
    };
}

$data = [1, 2, 3];
$results = map($data, function ($i) { return $i * 2; });
var_dump($results);
