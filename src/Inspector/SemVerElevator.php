<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\Schema;

/**
 * Class to increase an existing version number by the next version depending on the changes between the left and right
 * schema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SemVerElevator
{
    public function elevate(string $baseVersion, Schema $left, ?Schema $right = null): string
    {
        if ($right === null) {
            return '0.1.0';
        }

        $parts = explode('.', $baseVersion, 3);
        $major = (int) ($parts[0] ?? 0);
        $minor = (int) ($parts[1] ?? 0);
        $patch = (int) ($parts[2] ?? 0);

        $level = $this->getMaxSemVerLevel($left, $right);
        if ($level === ChangelogGenerator::LEVEL_MAJOR) {
            $major++;
            $minor = 0;
            $patch = 0;
        } elseif ($level === ChangelogGenerator::LEVEL_MINOR) {
            $minor++;
            $patch = 0;
        } else {
            $patch++;
        }

        return implode('.', [$major, $minor, $patch]);
    }

    private function getMaxSemVerLevel(Schema $left, Schema $right): string
    {
        $generator = new ChangelogGenerator();
        $levels = [];
        foreach ($generator->generate($left, $right) as $level => $message) {
            $levels[$level] = $level;
        }

        if (isset($levels[ChangelogGenerator::LEVEL_MAJOR])) {
            return ChangelogGenerator::LEVEL_MAJOR;
        } elseif (isset($levels[ChangelogGenerator::LEVEL_MINOR])) {
            return ChangelogGenerator::LEVEL_MINOR;
        } else {
            return ChangelogGenerator::LEVEL_PATCH;
        }
    }
}
