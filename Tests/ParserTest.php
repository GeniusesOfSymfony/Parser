<?php
namespace Gos\Component\Parser\Tests;

use Gos\Component\Parser\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testYaml()
    {
        $data = Parser::yaml(__DIR__.'/Fixture/TestYaml.yml');

        $this->assertEquals([
            'foo' => [
                'bar' => [1,2,3],
                'baz' => [4,5,6]
            ]
        ], $data);
    }

    public function testYamlWithPath()
    {
        $data = Parser::yaml(__DIR__.'/Fixture/TestYaml.yml', 'foo.bar');
        $this->assertEquals([1,2,3], $data);

        $data = Parser::yaml(__DIR__.'/Fixture/TestYaml.yml', 'foo.baz');
        $this->assertEquals([4,5,6], $data);
    }

    public function stringToSlugProvider()
    {
        return [
            ['Foo bar 123@34|(){}[]#~&=-+*%!:.;?,"'],
            ['john-doe'],
            ['&nbsp <html><script>alert(\'lol\');</script></html>']
        ];
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
//        $this->assertEquals('FooBar', Parser::camelize('FOO BAR')); Not supported yet
    }
}
