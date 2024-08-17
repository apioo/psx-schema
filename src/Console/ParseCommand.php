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

namespace PSX\Schema\Console;

use PSX\Schema\Generator\Code\Chunks;
use PSX\Schema\Generator\Config;
use PSX\Schema\Generator\FileAwareInterface;
use PSX\Schema\GeneratorFactory;
use PSX\Schema\SchemaManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * ParseCommand
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ParseCommand extends Command
{
    private SchemaManagerInterface $schemaManager;

    public function __construct(SchemaManagerInterface $schemaManager)
    {
        parent::__construct();

        $this->schemaManager = $schemaManager;
    }

    protected function configure(): void
    {
        $this
            ->setName('schema:parse')
            ->setDescription('Parses an arbitrary source and outputs the schema in a specific format')
            ->addArgument('source', InputArgument::REQUIRED, 'The schema source this is either a absolute class name or schema file')
            ->addArgument('target', InputArgument::OPTIONAL, 'Optional the target folder otherwise the CWD is used')
            ->addOption('format', 'f', InputOption::VALUE_REQUIRED, 'Optional the output format possible values are: ' . implode(', ', GeneratorFactory::getPossibleTypes()))
            ->addOption('config', 'c', InputOption::VALUE_REQUIRED, 'Optional a config value which gets passed to the generator');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $source = $input->getArgument('source');
        $target = $input->getArgument('target') ?: getcwd();
        $schema = $this->schemaManager->getSchema($source);

        if (!is_dir($target)) {
            throw new \RuntimeException('Target is not a directory');
        }

        $factory   = new GeneratorFactory();
        $config    = Config::fromQueryString($input->getOption('config'));
        $generator = $factory->getGenerator($input->getOption('format'), $config);
        $response  = $generator->generate($schema);

        if ($generator instanceof FileAwareInterface && $response instanceof Chunks) {
            $result = $response->writeToFolder(
                $target,
                fn (string $fileName) => $generator->getFileName($fileName),
                fn (string $code) => $generator->getFileContent($code)
            );

            $count = 0;
            foreach ($result as $file) {
                $output->writeln('Wrote: ' . $file);
                $count++;
            }

            $output->writeln('Generated ' . $count . ' files at ' . $target);
        } else {
            $output->write((string) $response);
        }

        return self::SUCCESS;
    }
}
