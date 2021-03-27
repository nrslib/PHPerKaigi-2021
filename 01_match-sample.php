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
    $head = count($elements) > 0 ? $elements[0] : null;

    return match (true) {
        $head === null => $acc,
        default => $f($head, foldRight($acc, array_slice($elements, 1), $f))
    };
}

$data = [1, 2, 3];
$results = map($data, function ($i) { return $i * 2; });
var_dump($results);
