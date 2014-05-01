<?php
namespace Gos\Component\Parser\Tests;

use Gos\Component\Parser\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function stringToSlugProvider()
    {
        return array(
            array('Foo bar 123@34|(){}[]#~&=-+*%!:.;?,"'),
            array('john-doe'),
            array('&nbsp <html><script>alert(\'lol\');</script></html>')
        );
    }

    /**
     * @dataProvider stringToSlugProvider
     */
    public function testUrlize($string)
    {
        $slug = Parser::urlize($string);
        $this->assertTrue(preg_match("/^[a-z0-9-]+$/", $slug) === 1);
    }

    public function testUnderscore()
    {
        $this->assertEquals('foo bar', Parser::underscore('foo bar'));
        $this->assertEquals('foo_bar', Parser::underscore('foo bar', true));
        $this->assertEquals('foobar', Parser::underscore('foobar'));
        $this->assertEquals('foo_bar', Parser::underscore('fooBar'));
        $this->assertEquals('foo_bar', Parser::underscore('FooBar'));
    }

    public function testUnaccent()
    {
        $this->assertEquals('eeauoeiueuioc', Parser::unaccent('éèàùöïüûiôç'));
    }

    public function testCamelize()
    {
        $this->assertEquals('FooBar', Parser::camelize('foo bar'));
        $this->assertEquals('FooBar', Parser::camelize('foo_bar'));
        $this->assertEquals('FooBar', Parser::camelize('Foo_Bar'));
        $this->assertEquals('FooBar', Parser::camelize('Foo Bar'));
        $this->assertEquals('FooBar', Parser::camelize('fooBar'));
        $this->assertEquals('FooBar', Parser::camelize('fooBar'));
//        $this->assertEquals('FooBar', Parser::camelize('FOO BAR'));
    }
}
