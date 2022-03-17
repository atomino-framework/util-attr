# Attribute utility

Work easily with PHP8 Attributes!

```php
get(\ReflectionClass|\ReflectionMethod|string $reflection, string|null $method = null):static|null
all(\ReflectionClass|\ReflectionMethod|string $reflection, string|null $method = null):static|null
collect(\ReflectionClass|\ReflectionMethod ...$reflections):static[]
```

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
## Query Single Attribute (`get`)

```php
get(\ReflectionClass|\ReflectionMethod|string $reflection, string|null $method = null):static|null
```

> As a return value you will get an Attribute instance or null

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

## Query Repeatable Attribute (`all`)

```php
all(\ReflectionClass|\ReflectionMethod|string $reflection, string|null $method = null):static|null
```

> As a return value you will get an array with the Attribute instances in it

### Reflection based query

Then get the array of attributes based on the reflection of the class or method. The IDE will know what type of attribute you requested, the code completion will work.

```php
$classRef = new ReflectionClass(MyClass::class);
$attrs = MyRepeatableAttr::all($classRef);
foreach ($attrs as $attr) echo $attr->name;

$methodRef = $classRef->getMethod("myMethod");
$attrs = MyRepeatableAttr::all($methodRef);
foreach ($attrs as $attr) echo $attr->name;
```

### Name based query

If you don't want to use reflection, you can get the attributes by the class (and the method) name.

```php
$attrss = MyRepeatableAttr::all(MyClass::class);
foreach ($attrs as $attr) echo $attr->name;

$attrs = MyRepeatableAttr::all(MyClass::class, "myMethod");
foreach ($attrs as $attr) echo $attr->name;
```

## Query attributes of multiple reflections (`collect`)

```php
collect(\ReflectionClass|\ReflectionMethod ...$reflections):static[]
```

> As a return value you will get an array with the Attribute instances in it

If you want to retrieve the attributes of multiple classes or methods in bulk, you can do so using the `collect` method.

```php
$classRef = new ReflectionClass(MyClass::class);
$methodRefs = $classRef->getMethods();
$attrs = MyAttr::collect($classRef, ...$methodRefs);
foreach ($attrs as $attr) echo $attr->name;
```
