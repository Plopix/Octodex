<?php
/**
 * Octodex Provider - Test
 *
 * @package   Plopix\Octodex
 * @author    Sébastien Morel aka Plopix <morel.seb@gmail.com>
 * @copyright 2015 Plopix
 * @license   https://github.com/Plopix/Octodex/blob/master/LICENSE MIT Licence
 */
include_once(__DIR__ . "/../vendor/autoload.php");

$provider = new Plopix\Octodex\Provider();
$cat = $provider->getRandom();
print $cat;

print $provider->getNumber(42);

