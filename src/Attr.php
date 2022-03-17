<?php namespace Atomino\Neutrons;

abstract class Attr{
	public static function get(\ReflectionClass|\ReflectionMethod|string $reflection, string|null $method = null):static|null{
		if(is_string($reflection)) $reflection = new \ReflectionClass($reflection);
		if(is_string($method)) $reflection = $reflection->getMethod($method);
		$attributes = $reflection->getAttributes(static::class);
		if(count($attributes) === 0) return null;
		/** @var static $instance */
		$instance = $attributes[0]->newInstance();
		return $instance;
	}

	/** @return static[] */
	public static function collect(\ReflectionClass|\ReflectionMethod|string $reflection, string|null $method = null):array{
		if(is_string($reflection)) $reflection = new \ReflectionClass($reflection);
		if(is_string($method)) $reflection = $reflection->getMethod($method);
		$attributes = $reflection->getAttributes(static::class);
		return array_map(function (\ReflectionAttribute $attribute):static{return $attribute->newInstance();}, $attributes);
	}

	/** @return static[] */
	public static function all(\ReflectionClass|\ReflectionMethod ...$reflections):array{
		/** @var static[] $attributes */
		$attributes = [];
		foreach ($reflections as $reflection) array_push($attributes, ... $reflection->getAttributes(static::class));
		return array_map(function (\ReflectionAttribute $attribute):static{return $attribute->newInstance();}, $attributes);
	}
}
