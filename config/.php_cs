<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in('app')
    ->in('src')
    ->in('tests');

return Symfony\CS\Config\Config::create()
    ->finder($finder);
