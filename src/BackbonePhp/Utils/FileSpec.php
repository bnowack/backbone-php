<?php

namespace src\BackbonePhp\Utils;

use PhpSpec\ObjectBehavior;
use SpecHelper;

class FileSpec extends ObjectBehavior
{

    public function it_loads_json()
    {
        $this->loadJson(SpecHelper::fixturesPath() . 'config-1.json', true)->shouldBeArray();
        $this->loadJson(SpecHelper::fixturesPath() . 'config-1.json')->shouldHaveType('\stdClass');
        $this->shouldThrow('BackbonePhp\Exception\InvalidJsonException')->duringLoadJson(SpecHelper::fixturesPath() . 'invalid-json.txt');
        $this->shouldThrow('BackbonePhp\Exception\FileNotFoundException')->duringLoadJson(SpecHelper::fixturesPath() . 'does-not-exist.json');
    }
    
}
