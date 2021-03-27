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

$fieldAttributeTestClazz = new ReflectionClass(Constants::class);
$methods = $fieldAttributeTestClazz->getMethods();
$constants = $fieldAttributeTestClazz->getConstants();
$key = array_search($constant, $constants);
$constantReflection = new ReflectionClassConstant(Constants::class, $key);
$textAttributeReflection = $constantReflection->getAttributes(Text::class)[0];
$textAttribute = $textAttributeReflection->newInstance();

echo $textAttribute->value;