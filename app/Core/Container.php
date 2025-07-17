<?php

namespace App\Core;

use ReflectionClass;
use Exception;

class Container {
    private static $instance;
    protected $bindings = [];

    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function bind(string $abstract, $concrete = null) {
        if ($concrete === null) {
            $concrete = $abstract;
        }
        $this->bindings[$abstract] = $concrete;
    }

    public function get(string $abstract) {
        if (!isset($this->bindings[$abstract])) {
            // If not explicitly bound, try to resolve it directly
            return $this->resolve($abstract);
        }

        $concrete = $this->bindings[$abstract];

        if ($concrete instanceof \Closure) {
            return $concrete($this);
        }

        return $this->resolve($concrete);
    }

    private function resolve(string $class) {
        $reflector = new ReflectionClass($class);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class {$class} is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return $reflector->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    private function getDependencies(array $parameters): array {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType();

            if ($dependency === null || $dependency->isBuiltin()) {
                 if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new Exception("Cannot resolve primitive parameter {$parameter->name} in class {$parameter->getDeclaringClass()->getName()}");
                }
            } else {
                $dependencies[] = $this->get($dependency->getName());
            }
        }
        return $dependencies;
    }
}