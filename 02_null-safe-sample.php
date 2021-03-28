<?php

class DataContainer
{
    private string $msg;

    public function __construct(string $msg)
    {
        $this->msg = $msg;
    }

    public function getMessage(): string
    {
        return $this->msg;
    }
}

$variable = new DataContainer("msg");
// コメントアウトすると null のときの挙動が確認できる
//$variable = null;
$message = $variable?->getMessage() ?? "";
echo $message;

// いわゆるエルビス演算子
$message = $variable?->getMessage() ? /* 第二項*/ : "";
echo $message;