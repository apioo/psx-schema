<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\Generator;
use PSX\Schema\SchemaManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * SchemaCommand
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaCommand extends Command
{
    /**
     * @var \PSX\Schema\SchemaManager
     */
    protected $schemaManager;

    /**
     * @param \PSX\Schema\SchemaManager $schemaManager
     */
    public function __construct(SchemaManager $schemaManager)
    {
        parent::__construct();

        $this->schemaManager = $schemaManager;
    }

    protected function configure()
    {
        $this
            ->setName('schema')
            ->setDescription('Parses an arbitrary source and outputs the schema in a specific format')
            ->addOption('namespace',null,InputOption::VALUE_REQUIRED,'Namespace for generated PHP classes')
            ->addArgument('source', InputArgument::REQUIRED, 'The schema source this is either a absolute class name or schema file')
            ->addArgument('format', InputArgument::OPTIONAL, 'Optional the output format possible values are: html, php, serialize, jsonschema');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $schema = $this->schemaManager->getSchema($input->getArgument('source'));

        switch ($input->getArgument('format')) {
            case 'html':
                $generator = new Generator\Html();
                $response  = $generator->generate($schema);
                break;

            case 'php':
                $generator = new Generator\Php($input->getOption('namespace'));
                $response  = $generator->generate($schema);
                break;

            case 'serialize':
                $response = serialize($schema);
                break;

            default:
            case 'jsonschema':
                $generator = new Generator\JsonSchema();
                $response  = $generator->generate($schema);
                break;
        }

        $output->write($response);
    }
}
