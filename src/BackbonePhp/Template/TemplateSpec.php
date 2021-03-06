<?php

namespace src\BackbonePhp\Template;

use PhpSpec\ObjectBehavior;
use SpecHelper;

class TemplateSpec extends ObjectBehavior
{
    
    function it_is_initializable()
    {
        $this->shouldHaveType('BackbonePhp\Template\Template');
    }
    
    function it_sets_its_content()
    {
        $this->setContent('test')->getContent()->shouldReturn('test');
    }
    
    function it_sets_variables()
    {
        $this->set('foo', 'bar')->shouldReturn($this);
    }
    
    function it_renders_placeholders()
    {
        $this->setContent('1{var}3')->render()->getContent()->shouldReturn('1{var}3');
        $this->setContent('1{var}3')->set('var', '2')->render()->getContent()->shouldReturn('123');
        $this->setContent('1{var}3')->set('var', 2)->render()->getContent()->shouldReturn('123');
    }
    
    function it_renders_numeric_variable_names()
    {
        $this->setContent('1{0}3')->set(0, '2')->render()->getContent()->shouldReturn('123');
        $this->setContent('1{0}3')->set(0, 2)->render()->getContent()->shouldReturn('123');
    }
    
    function it_renders_complex_variables_as_json_strings()
    {
        $this
            ->setContent('{a}{b}')
            ->set('a', ['foo', 'bar'])
            ->set('b', (object)['baz' => 'bat'])
            ->render()->getContent()
            ->shouldReturn('["foo","bar"]{"baz":"bat"}')
        ;
    }
    
    function it_renders_nested_placeholders()
    {
        $this->setContent('1{foo}')
            ->set('foo', '{bar}4')
            ->set('bar', '2{baz}')
            ->set('baz', '3')
            ->render()
            ->getContent()->shouldReturn('1234')
        ;
    }
    
    function it_sets_default_template_variables()
    {
        $this->beConstructedWith(SpecHelper::getDevConfig());
        $this->setContent('{appBase}')->render()->getContent()->shouldReturn('/');
    }
    
    function it_renders_sub_templates()
    {
        $path = SpecHelper::fixturesPath() . 'static-body.html.tpl';
        $actual = $this->setContent("{{$path}}")->render()->getContent();
        $actual->shouldContain('Hello Static');
    }
    
}
