<?php

#[Attribute]
class Text
{
    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }
}

class Constants
{
    #[Text("one")]
    const CONSTANT1 = 1;

    #[Text("two")]
    const CONSTANT2 = 2;
}

$constant = Constants::CONSTANT1;

// Constants クラスから const のフィールド名を取得する
$constantsClazz = new ReflectionClass(Constants::class);
$constants = $constantsClazz->getConstants();
$key = array_search($constant, $constants);

// フィールドに定義された属性を取得する
$constantReflection = new ReflectionClassConstant(Constants::class, $key);
$textAttributeReflection = $constantReflection->getAttributes(Text::class)[0];
$textAttribute = $textAttributeReflection->newInstance();

// 取得された属性のプロパティを取得
echo $textAttribute->value;