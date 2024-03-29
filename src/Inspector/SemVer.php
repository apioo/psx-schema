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

namespace PSX\Schema\Inspector;

/**
 * SemVer
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SemVer
{
    public const MAJOR = 'major';
    public const MINOR = 'minor';
    public const PATCH = 'patch';

    private int $major;
    private int $minor;
    private int $patch;

    public function __construct(int $major, int $minor, int $patch)
    {
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
    }

    public function getMajor(): int
    {
        return $this->major;
    }

    public function getMinor(): int
    {
        return $this->minor;
    }

    public function getPatch(): int
    {
        return $this->patch;
    }

    public function equals(SemVer $version): bool
    {
        return version_compare($this->toString(), $version->toString()) === 0;
    }

    public function greater(SemVer $version): bool
    {
        return version_compare($this->toString(), $version->toString()) === 1;
    }

    public function lower(SemVer $version): bool
    {
        return version_compare($this->toString(), $version->toString()) === -1;
    }

    public function increase(string $type): void
    {
        if ($type === self::MAJOR) {
            $this->increaseMajor();
        } elseif ($type === self::MINOR) {
            $this->increaseMinor();
        } elseif ($type === self::PATCH) {
            $this->increasePatch();
        } else {
            throw new \InvalidArgumentException('Provided an invalid semantic versioning type, must be either major, minor or patch');
        }
    }

    public function increaseMajor(): void
    {
        $this->major++;
        $this->minor = 0;
        $this->patch = 0;
    }

    public function increaseMinor(): void
    {
        $this->minor++;
        $this->patch = 0;
    }

    public function increasePatch(): void
    {
        $this->patch++;
    }

    public function toString(): string
    {
        return implode('.', [$this->major, $this->minor, $this->patch]);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public static function fromString(string $version): self
    {
        $parts = explode('.', $version, 3);

        return new self(
            (int) ($parts[0] ?? 0),
            (int) ($parts[1] ?? 0),
            (int) ($parts[2] ?? 0)
        );
    }
}
