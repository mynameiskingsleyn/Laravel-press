<?php

namespace Kings\Press\Tests\Feature;

use Carbon\Carbon;
use Kings\Press\PressFileParser;
use Kings\Press\Tests\TestCase;

//use Orchestra\Testbench\TestCase;

class PressFileParserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function the_head_and_body_gets_split()
    {
        $pressFileParser = new PressFileParser(__DIR__.'/../blogs/MarkFile1.md');
        $data = $pressFileParser->getRawData();
        //dd($data);

        $this->assertStringContainsString('title: My Title', $data[1]);
        $this->assertStringContainsString('description: Description here', $data[1]);
        $this->assertStringContainsString('Blog post body', $data[2]);
    }

    /** @test */
    public function a_string_can_also_be_used_instead()
    {
        $pressFileParser = new PressFileParser("---\ntitle: My Title\n---\nBlog post body");
        $data = $pressFileParser->getRawData();
        //dd($data);
        $this->assertStringContainsString('title: My Title', $data[1]);
        $this->assertStringContainsString('Blog post body', $data[2]);
    }

    /** @test */
    public function each_head_field_gets_seperated()
    {
        $pressFileParser = new PressFileParser(__DIR__.'/../blogs/MarkFile1.md');
        $data = $pressFileParser->getData();
        $this->assertEquals('My Title', $data['title']);
        $this->assertEquals('Description here', $data['description']);
    }

    /** @test */
    public function the_body_gets_saved_and_trimmed()
    {
        $pressFileParser = new PressFileParser(__DIR__.'/../blogs/MarkFile1.md');
        $data = $pressFileParser->getData();
        $this->assertEquals("<h1>Heading</h1>\n<p>Blog post body</p>", $data['body']);
    }

    /** @test */
    public function a_date_field_gets_parsed()
    {
        $pressFileParser = new PressFileParser("---\ntitle: My Title\ndate: May 14 1988\n---\nBlog post body");
        $data = $pressFileParser->getData();
        //dd($data);
        $this->assertInstanceOf(Carbon::class, $data['date']);
        $this->assertEquals('05/14/1988', $data['date']->format('m/d/Y'));
    }

    /** @test */
    public function an_extra_field_gets_saved()
    {
        $pressFileParser = new PressFileParser("---\nauthor: Jacob doe\ndate: May 14 1988\n---\nBlog post body");
        $data = $pressFileParser->getData();
        $this->assertEquals(json_encode(['author'=>'Jacob doe']), $data['extra']);
    }

    /** @test */
    public function two_additional_fields_are_put_into_extra()
    {
        $pressFileParser = new PressFileParser("---\ntitle: My Title\nauthor: Jacob doe\ndate: May 14 1988\nimage: some/image.jpg---\nBlog post body");
        $data = $pressFileParser->getData();
        //dd($data);
        $this->assertEquals(
            json_encode(['author'=>'Jacob doe','image'=>'some/image.jpg']),
            $data['extra']
        );
    }

    /** @test */
    public function other_fields_are_captured()
    {
        $pressFileParser = new PressFileParser(__DIR__.'/../blogs/MarkFile1.md');
        $data = $pressFileParser->getData();
        //dd($data);
        $this->assertEquals('My Title', $data['title']);
        $this->assertEquals('Description here', $data['description']);
        $this->assertStringContainsString('"Author":"John Carter"', $data['extra']);
    }
}
