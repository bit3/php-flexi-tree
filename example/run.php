<?php

spl_autoload_register(
    function($className) {
        if (strpos($className, 'Bit3\\FlexiTree\\Example\\') === 0) {
            $path = __DIR__;
        }
        else if (strpos($className, 'Bit3\\FlexiTree\\') === 0) {
            $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src';
        }
        else {
            return;
        }

        $file = $path . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        require_once($file);
    }
);

use Bit3\FlexiTree\Builder;
use Bit3\FlexiTree\Example\FileProvider;
use Bit3\FlexiTree\Example\FileRenderer;
use Bit3\FlexiTree\Renderer\TreeRenderer;

$path = $argc > 1 ? $argv[1] : getcwd();

$fileProvider = new FileProvider();

$builder = new Builder();
$builder->addItemDataSource($fileProvider);
$builder->addItemFactory($fileProvider);
$builder->setRoot(new SplFileInfo($path));

$tree = $builder->generate();

$fileRenderer = new FileRenderer();

$renderer = new TreeRenderer();
$renderer->setItemListRenderer($fileRenderer);
$renderer->addItemRenderer($fileRenderer);

echo $renderer->renderTree($tree);
