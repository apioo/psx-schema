<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Document;

/**
 * Operation
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Operation implements \JsonSerializable
{
    private ?string $name;
    private ?string $description;
    private ?string $httpMethod;
    private ?string $httpPath;
    private ?int $httpCode;
    /**
     * @var array<Argument>
     */
    private array $arguments = [];
    /**
     * @var array<Error>
     */
    private array $throws = [];
    private ?string $return;
    private ?int $stability;
    private ?array $security;
    private ?bool $authorization;
    private ?array $tags;

    public function __construct(array $operation)
    {
        $this->name = $operation['name'] ?? null;
        $this->description = $operation['description'] ?? null;
        $this->httpMethod = $operation['httpMethod'] ?? null;
        $this->httpPath = $operation['httpPath'] ?? null;
        $this->httpCode = $operation['httpCode'] ?? null;
        $this->return = $operation['return'] ?? null;
        $this->stability = $operation['stability'] ?? null;
        $this->security = $operation['security'] ?? null;
        $this->authorization = $operation['authorization'] ?? null;
        $this->tags = $operation['tags'] ?? null;

        if (isset($operation['arguments']) && is_array($operation['arguments'])) {
            $this->arguments = $this->convertArguments($operation['arguments']);
        }

        if (isset($operation['throws']) && is_array($operation['throws'])) {
            $this->throws = $this->convertThrows($operation['throws']);
        }
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getHttpMethod(): ?string
    {
        return $this->httpMethod;
    }

    public function setHttpMethod(?string $httpMethod): void
    {
        $this->httpMethod = $httpMethod;
    }

    public function getHttpPath(): ?string
    {
        return $this->httpPath;
    }

    public function setHttpPath(?string $httpPath): void
    {
        $this->httpPath = $httpPath;
    }

    public function getHttpCode(): ?int
    {
        return $this->httpCode;
    }

    public function setHttpCode(?int $httpCode): void
    {
        $this->httpCode = $httpCode;
    }

    /**
     * @return array<Argument>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function setArguments(?array $arguments): void
    {
        $this->arguments = $arguments;
    }

    public function getArgument(int $index): ?Argument
    {
        return $this->arguments[$index] ?? null;
    }

    public function indexOfArgument(string $argumentName): ?int
    {
        foreach ($this->arguments as $index => $argument) {
            if ($argument->getName() === $argumentName) {
                return $index;
            }
        }

        return null;
    }

    /**
     * @return array<Error>
     */
    public function getThrows(): array
    {
        return $this->throws;
    }

    public function setThrows(?array $throws): void
    {
        $this->throws = $throws;
    }

    public function getThrow(int $index): ?Error
    {
        return $this->throws[$index] ?? null;
    }

    public function indexOfThrow(int $throwCode): ?int
    {
        foreach ($this->throws as $index => $throw) {
            if ($throw->getCode() === $throwCode) {
                return $index;
            }
        }

        return null;
    }

    public function getReturn(): ?string
    {
        return $this->return;
    }

    public function setReturn(?string $return): void
    {
        $this->return = $return;
    }

    public function getStability(): ?int
    {
        return $this->stability;
    }

    public function setStability(?int $stability): void
    {
        $this->stability = $stability;
    }

    public function getSecurity(): ?array
    {
        return $this->security;
    }

    public function setSecurity(?array $security): void
    {
        $this->security = $security;
    }

    public function getAuthorization(): ?bool
    {
        return $this->authorization;
    }

    public function setAuthorization(?bool $authorization): void
    {
        $this->authorization = $authorization;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): void
    {
        $this->tags = $tags;
    }

    public function jsonSerialize(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'httpMethod' => $this->httpMethod,
            'httpPath' => $this->httpPath,
            'httpCode' => $this->httpCode,
            'arguments' => $this->arguments,
            'throws' => $this->throws,
            'return' => $this->return,
            'stability' => $this->stability,
            'security' => $this->security,
            'authorization' => $this->authorization,
            'tags' => $this->tags,
        ], function ($value) {
            return $value !== null;
        });
    }

    private function convertArguments(array $arguments): array
    {
        $result = [];
        foreach ($arguments as $argument) {
            if ($argument instanceof \stdClass) {
                $result[] = new Argument((array) $argument);
            } elseif (is_array($argument)) {
                $result[] = new Argument($argument);
            }
        }

        return $result;
    }

    private function convertThrows(array $throws): array
    {
        $result = [];
        foreach ($throws as $throw) {
            if ($throw instanceof \stdClass) {
                $result[] = new Error((array) $throw);
            } elseif (is_array($throw)) {
                $result[] = new Error($throw);
            }
        }

        return $result;
    }
}
