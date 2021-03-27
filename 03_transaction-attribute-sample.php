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

$arg = null;
$module = new AttributeTestClass();
$clazz = new ReflectionClass($module);
$handleMethod = $clazz->getMethod("handle");
$handleMethodAttributes = $handleMethod->getAttributes(Transactional::class);
$needTransaction = count($handleMethodAttributes) !== 0;

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
