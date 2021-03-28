<?php

#[Attribute(Attribute::TARGET_METHOD)]
class Transactional
{
}

class AttributeTestClass
{
    #[Transactional]
    public function handle()
    {
    }
}

/** Dummy */
class DB
{
    public static function beginTransaction()
    {
    }

    public static function commit()
    {
    }

    public static function rollback()
    {
    }
}

// トランザクション制御対象の引数（今回は引数無し）
$arg = null;

// トランザクション制御対象
$module = new AttributeTestClass();

// 制御対象のメソッドに Transactional 属性が定義されているか確認する
$clazz = new ReflectionClass($module);
$handleMethod = $clazz->getMethod("handle");
$handleMethodAttributes = $handleMethod->getAttributes(Transactional::class);
$needTransaction = count($handleMethodAttributes) !== 0;

// トランザクションを制御しながらメソッドを呼び出す
// 実際は AOP 的な仕組みを導入して開発者がこのコードを書くことはないようにする
try {
    if ($needTransaction) {
        DB::beginTransaction();
    }

    $handleMethod->invoke($module, $arg);

    if ($needTransaction) {
        DB::commit();
    }
} catch (Exception $e) {
    if ($needTransaction) {
        DB::rollback();
    }
    throw $e;
}
