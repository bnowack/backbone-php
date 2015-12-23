<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;
use spec\Spec;

class FileSpec extends ObjectBehavior
{

    public function it_loads_json()
    {
        $this->loadJson(Spec::fixturesPath() . 'config-1.json', true)->shouldBeArray();
        $this->loadJson(Spec::fixturesPath() . 'config-1.json')->shouldHaveType('\stdClass');
        $this->shouldThrow('BackbonePhp\Exception\InvalidJsonException')->duringLoadJson(Spec::fixturesPath() . 'invalid-json.txt');
        $this->shouldThrow('BackbonePhp\Exception\FileNotFoundException')->duringLoadJson(Spec::fixturesPath() . 'does-not-exist.json');
    }
    
}
