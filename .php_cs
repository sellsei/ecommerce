<?php

use Symfony\CS\FixerInterface;

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->notName('*.yml')
    ->notName('*.xml')
    ->notName('*Spec.php')
    ->exclude('app')
;

return Symfony\CS\Config\Config::create()->finder($finder);
