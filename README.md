# Attribute utility

Work easily with PHP8 Attributes!

## Usage

### Single Attribute

Create the `Attribute` class as usual, just extend it from the `\Atomino\Neutrons\Attr` class.

```php
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class MyAttr extends \Atomino\Neutrons\Attr
{
  public function __construct(public string $name){...}
}
```

Add the attribute to a class or a method

```php
#[MyAttr("my awesome class")]
class MyClass
{
  #[MyAttr("my awesome method")]
  public function myMethod(){...}
}
```

Then get the attribute based on the reflection of the class or method. The IDE will know what type of attribute you requested, the code completion will work.

```php
$classRef = new ReflectionClass(MyClass::class);
$attr = MyAttr::get($classRef);
echo $attr->name;

$methodRef = $classRef->getMethod("myMethod");
$attr = MyAttr::get($methodRef);
echo $attr->name;
```

### Repeatable Attribute

Create the `Attribute` class as usual, just extend it from the `\Atomino\Neutrons\Attr` class.

```php
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class MyAttr extends \Atomino\Neutrons\Attr
{
  public function __construct(public string $name){...}
}
```

Add the attribute to a class or a method

```php
#[MyAttr("my awesome class")]
class MyClass
{
  #[MyAttr("my awesome method")]
  #[MyAttr("my awesome method's second attribute")]
  public function myMethod(){...}
}
```

Then get the array of attributes based on the reflection of the class or method. The IDE will know what type of attribute you requested, the code completion will work.

```php
$classRef = new ReflectionClass(MyClass::class);
$attrs = MyAttr::all($classRef);
print_r($attr->name);

$methodRef = $classRef->getMethod("myMethod");
$attr = MyAttr::get($methodRef);
print_r($attr->name);
```
