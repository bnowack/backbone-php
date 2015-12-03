<?php

namespace spec\BackbonePhp;

use PhpSpec\ObjectBehavior;

class FileSpec extends ObjectBehavior
{

    protected static function fixturesPath() {
        return __DIR__ . '/../../fixtures/';
    }
    
    public function it_loads_json()
    {
        $this->loadJson(self::fixturesPath() . 'config-1.json', true)->shouldBeArray();
        $this->loadJson(self::fixturesPath() . 'config-1.json')->shouldHaveType('\stdClass');
        $this->shouldThrow('BackbonePhp\Exception\InvalidJsonException')->duringLoadJson(self::fixturesPath() . 'invalid-json.txt');
        $this->shouldThrow('BackbonePhp\Exception\FileNotFoundException')->duringLoadJson(self::fixturesPath() . 'does-not-exist.json');
    }
    
}
