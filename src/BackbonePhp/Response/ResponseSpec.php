<?php

namespace src\BackbonePhp\Response;

use PhpSpec\ObjectBehavior;

use PHPUnit_Framework_TestCase as Assertions;

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
        $expected = 'test';
        $this->setBody($expected)->shouldReturn($this);
        $result = (object)[
            'actual' => ''
        ];
        ob_start(function($output) use ($result) {
            $result->actual = $output;
            return null;
        });
        $this->sendBody()->shouldReturn($this);
        ob_end_flush();
        Assertions::assertEquals($expected, $result->actual, 'should send body');
    }
    
    public function it_sends_a_non_string_body_as_json()
    {
        $struct = array('test' => 'test');
        $this->setBody($struct)->shouldReturn($this);
        $result = (object)[
            'expected' => json_encode($struct, JSON_PRETTY_PRINT),
            'actual' => ''
        ];
        ob_start(function($output) use ($result) {
            $result->actual = $output;
            return null;
        });
        $this->sendBody()->shouldReturn($this);
        ob_end_flush();
        Assertions::assertEquals($result->expected, $result->actual, 'should send body as json');
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
