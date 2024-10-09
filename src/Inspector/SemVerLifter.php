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

namespace PSX\Schema\Inspector;

use PSX\Schema\DefinitionsInterface;

/**
 * Class to increase an existing version number by the next version depending on the changes between the left and right
 * definition
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SemVerLifter
{
    private ChangelogGenerator $generator;

    public function __construct()
    {
        $this->generator = new ChangelogGenerator();
    }

    public function elevate(string $baseVersion, DefinitionsInterface $left, ?DefinitionsInterface $right = null): string
    {
        if ($right === null) {
            return '0.1.0';
        }

        $version = SemVer::fromString($baseVersion);

        $level = $this->getMaxSemVerLevel($left, $right);
        if ($level === SemVer::MAJOR) {
            $version->increaseMajor();
        } elseif ($level === SemVer::MINOR) {
            $version->increaseMinor();
        } else {
            $version->increasePatch();
        }

        return $version->toString();
    }

    private function getMaxSemVerLevel(DefinitionsInterface $left, DefinitionsInterface $right): string
    {
        $levels = [];
        foreach ($this->generator->generate($left, $right) as $level => $message) {
            $levels[$level] = $level;
        }

        if (isset($levels[SemVer::MAJOR])) {
            return SemVer::MAJOR;
        } elseif (isset($levels[SemVer::MINOR])) {
            return SemVer::MINOR;
        } else {
            return SemVer::PATCH;
        }
    }
}
