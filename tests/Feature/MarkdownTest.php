<?php

namespace Kings\Press\Tests;

use Kings\Press\MarkdownParser;
use Kings\Press\Tests\TestCase;

use \Parsedown;

class MarkdownTest extends TestCase
{
    /** @test */
    public function simple_markdown_is_persed()
    {
        //$parsedown = new Parsedown();
        $result = MarkdownParser::parse('# Heading');
        $this->assertEquals('<h1>Heading</h1>', $result);
    }
}
