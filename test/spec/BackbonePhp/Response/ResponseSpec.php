<?php

namespace spec\BackbonePhp\Response;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Response\Response');
    }
    
    function it_sets_and_gets_a_header()
    {
        $this->setHeader('Content-Type', 'application/json')->shouldReturn($this);
        $this->getHeader('Content-Type')->shouldReturn('application/json');
        $this->getHeader('unknown')->shouldReturn(null);
    }
    
    function it_sets_the_content_type()
    {
        $this
            ->setType('application/json')
            ->getHeader('Content-Type')->shouldReturn('application/json')
        ;
    }
    
    function it_finds_a_header_case_insensitively()
    {
        $this->setHeader('Content-type', 'application/json')->shouldReturn($this);
        $this->getHeader('conTent-TypE')->shouldReturn('application/json');
    }
    
    public function it_sets_a_code() {
        $this->setCode(200)->shouldReturn($this);
        $this->getCode()->shouldReturn(200);
    }
    
    public function it_is_successful_for_2xx_codes()
    {
        $this->setCode(200);
        $this->isSuccessful()->shouldReturn(true);
        
        $this->setCode(400);
        $this->isSuccessful()->shouldReturn(false);
    }
    
    function it_sets_and_gets_the_body()
    {
        // text
        $this->setBody('test')->shouldReturn($this);
        $this->getBody()->shouldReturn('test');
        // struct
        $struct = array('te' => 'st');
        $this->setBody($struct)->shouldReturn($this);
        $this->getBody()->shouldReturn($struct);
    }
    
    public function it_sends_headers()
    {
        // not fully testable at spec level
        $this->setHeader('Content-Type', 'application/json')->shouldReturn($this);
        $this->sendHeaders()->shouldReturn($this);
    }
    
    public function it_sends_a_body()
    {
        $struct = array('test' => 'test');
        $expected = json_encode($struct, JSON_PRETTY_PRINT);
        $this->setBody($struct)->shouldReturn($this);
        ob_start(function($actual) use ($expected) {
            if ($actual !== $expected) {
                throw new \Exception('should send correct body (' . $actual . ' !== ' . $expected . ')');
            }
            return null;
        });
        $this->sendBody()->shouldReturn($this);
        ob_end_flush();
    }
    
    public function it_sets_a_cookie()
    {
        // not fully testable at spec level
        $cookie = (object) [
            'name' => 'foo',
            'value' => 'bar',
            'path' => '/'
        ];
        $this->setCookie($cookie)->shouldReturn($this);
        $this->sendHeaders()->shouldReturn($this);
    }
    
    public function it_sends_cookies()
    {
        // not fully testable at spec level
        $cookie = (object) [
            'name' => 'foo',
            'value' => 'bar',
            'path' => '/'
        ];
        $this->setCookie($cookie)->shouldReturn($this);
        $this->sendCookie($cookie)->shouldReturn($this);
    }
    
}
