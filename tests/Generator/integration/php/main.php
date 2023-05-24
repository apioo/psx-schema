<?php

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/Location.php';
require_once __DIR__ . '/Web.php';
require_once __DIR__ . '/Meta.php';
require_once __DIR__ . '/Author.php';
require_once __DIR__ . '/News.php';

$data = json_decode(file_get_contents(__DIR__ . '/../input.json'));

$schemaManager = new \PSX\Schema\SchemaManager();
$schema = $schemaManager->getSchema(News::class);

try {
    $news = (new \PSX\Schema\SchemaTraverser())->traverse($data, $schema, new \PSX\Schema\Visitor\TypeVisitor());

    file_put_contents(__DIR__ . '/../output.json', \json_encode($news));
} catch (\PSX\Schema\Exception\ValidationException $e) {
    // the validation failed
    echo $e->getMessage();
    exit(1);
}
