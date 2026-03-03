<?php

declare(strict_types = 1);

namespace Tests\PHPStan;

use Illuminate\Testing\TestResponse;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;

final class TestResponseLivewireMacroExtension implements MethodsClassReflectionExtension
{

    private const array MACROS = ['assertSeeLivewire', 'assertDontSeeLivewire'];

    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        return $classReflection->getName() === TestResponse::class
            && in_array($methodName, self::MACROS, true);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        return new TestResponseMacroMethodReflection($classReflection, $methodName);
    }

}
