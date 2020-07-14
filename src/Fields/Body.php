<?php

namespace Kings\Press\Fields;

use Kings\Press\MarkdownParser;

use Carbon\Carbon;

class Body extends FieldContract
{
    public static function process($type,$value,$data=[])
    {
        return[
            $type=>MarkdownParser::parse($value)
        ];
    }
}