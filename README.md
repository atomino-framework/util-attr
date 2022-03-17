# Attribute utility

Work easily with PHP8 Attributes!

## Create Attributes

Create the `Attribute` class as usual, just extend it from the `\Atomino\Neutrons\Attr` class.

```php
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class MyAttr extends \Atomino\Neutrons\Attr
{
  public function __construct(public string $name){...}
}

#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class MyRepeatableAttr extends \Atomino\Neutrons\Attr
{
  public function __construct(public string $name){...}
}
```

Add the attribute to a class or a method

```php
#[MyAttr("my awesome class")]
#[MyRepeatableAttr("my awesome class")]
class MyClass
{
  #[MyAttr("my awesome method")]
  #[MyRepeatableAttr("my awesome method")]
  #[MyRepeatableAttr("my awesome method two")]
  public function myMethod(){...}
}
```
## Single Attribute (`get`)

| As a return value you will get an Attribute instance

### Reflection based query

Then get the attribute based on the reflection of the class or method.
The IDE will know what type of attribute you requested, the code completion will work.

```php
$classRef = new ReflectionClass(MyClass::class);
$attr = MyAttr::get($classRef);
echo $attr->name;

$methodRef = $classRef->getMethod("myMethod");
$attr = MyAttr::get($methodRef);
echo $attr->name;
```

### Name based query

If you don't want to use reflection, you can get the attribute by the class (and the method) name.

```php
$attr = MyAttr::get(MyClass::class);
echo $attr->name;

$attr = MyAttr::get(MyClass::class, "myMethod");
echo $attr->name;
```

## Repeatable Attribute (`collect`)

| As a return value you will get an array with the Attribute instances in it

### Reflection based query

Then get the array of attributes based on the reflection of the class or method. The IDE will know what type of attribute you requested, the code completion will work.

```php
$classRef = new ReflectionClass(MyClass::class);
$attrs = MyAttr::all($classRef);
print_r($attr->name);

$methodRef = $classRef->getMethod("myMethod");
$attr = MyAttr::get($methodRef);
print_r($attr->name);
```

### Name based query

If you don't want to use reflection, you can get the attributes by the class (and the method) name.

```php
$attrs = MyRepeatableAttr::collect(MyClass::class);
print_r($attr->name);

$attr = MyRepeatableAttr::collect(MyClass::class, "myMethod");
print_r($attr->name);
```

## Query attributes of multiple reflections (`all`)

| As a return value you will get an array with the Attribute instances in it

If you want to retrieve the attributes of multiple classes or methods in bulk, you can do so using the `all` method.

```php
$classRef = new ReflectionClass(MyClass::class);
$methodRef = $classRef->getMethod("myMethod");
$attr = MyAttr::all($classRef, $methodRef);
print_r($attr->name);
```
