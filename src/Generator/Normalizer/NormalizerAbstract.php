<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PSX\Schema\Generator\Normalizer;

/**
 * NormalizerAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class NormalizerAbstract implements NormalizerInterface
{
    protected function getArgumentStyle(): int
    {
        return self::CAMEL_CASE;
    }

    protected function hasArgumentReserved(): bool
    {
        return true;
    }

    protected function getPropertyStyle(): int
    {
        return self::CAMEL_CASE;
    }

    protected function hasPropertyReserved(): bool
    {
        return true;
    }

    protected function getMethodStyle(): int
    {
        return self::CAMEL_CASE;
    }

    protected function hasMethodReserved(): bool
    {
        return true;
    }

    protected function getClassStyle(): int
    {
        return self::PASCAL_CASE;
    }

    protected function hasClassReserved(): bool
    {
        return true;
    }

    protected function getFileStyle(): int
    {
        return self::PASCAL_CASE;
    }

    public function argument(string... $name): string
    {
        $name = implode('_', $name);
        $name = $this->sanitizeName($name);
        $name = $this->case($name, $this->getArgumentStyle());

        if ($this->hasArgumentReserved() && $this->isReservedKeyword($name)) {
            $name = $this->makeReservedNameUsable($name);
        }

        return $name;
    }

    public function property(string... $name): string
    {
        $name = implode('_', $name);
        $name = $this->sanitizeName($name);
        $name = $this->case($name, $this->getPropertyStyle());

        if ($this->hasPropertyReserved() && $this->isReservedKeyword($name)) {
            $name = $this->makeReservedNameUsable($name);
        }

        return $name;
    }

    public function method(string... $name): string
    {
        $name = implode('_', $name);
        $name = $this->sanitizeName($name);
        $name = $this->case($name, $this->getMethodStyle());

        if ($this->hasMethodReserved() && $this->isReservedKeyword($name)) {
            $name = $this->makeReservedNameUsable($name);
        }

        return $name;
    }

    public function class(string... $name): string
    {
        $name = implode('_', $name);
        $name = $this->sanitizeName($name);
        $name = $this->case($name, $this->getClassStyle());

        if ($this->hasClassReserved() && $this->isReservedKeyword($name)) {
            $name = $this->makeReservedNameUsable($name);
        }

        return $name;
    }

    public function file(string... $name): string
    {
        $name = implode('_', $name);

        return $this->case($name, $this->getFileStyle());
    }

    public function import(string $name, ?string $namespace = null): string
    {
        return $this->file($name);
    }

    /**
     * This method is called in case a reserved keyword was used and it should return a legal version of the name
     */
    protected function makeReservedNameUsable(string $name): string
    {
        return '_' . $name;
    }

    protected function isReservedKeyword(string $keyword): bool
    {
        return in_array($keyword, $this->getKeywords(), true);
    }

    /**
     * Returns an array of reserved keywords which the generator can not use
     */
    protected function getKeywords(): array
    {
        return [];
    }

    /**
     * This method should filter out all characters which can not be used at the target language as variable name
     */
    protected function sanitizeName(string $name): string
    {
        if (preg_match('/^[a-zA-Z_]*$/', $name)) {
            return $name;
        }

        return preg_replace('/[^a-zA-Z_]/', '_', $name);
    }

    private function case(string $name, int $style): string
    {
        if ($style === self::CAMEL_CASE) {
            return $this->camelCase($name);
        } elseif ($style === self::PASCAL_CASE) {
            return $this->pascalCase($name);
        } elseif ($style === self::SNAKE_CASE) {
            return $this->snakeCase($name);
        } else {
            throw new \InvalidArgumentException('Provided an invalid style');
        }
    }

    private function camelCase(string $name): string
    {
        return lcfirst($this->pascalCase($name));
    }

    private function pascalCase(string $name): string
    {
        return strtr(ucwords(strtr($name, ['_' => ' ', '.' => ' ', '\\' => ' '])), [' ' => '']);
    }

    private function snakeCase(string $name): string
    {
        return strtolower(preg_replace(['/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'], ['\\1_\\2', '\\1_\\2'], $name));
    }
}
