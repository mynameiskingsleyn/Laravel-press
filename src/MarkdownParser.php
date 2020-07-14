<?php

namespace Kings\Press;

class MarkdownParser
{
    public static function parse($string)
    {
        //$parsedown = new \Parsedown();

        return \Parsedown::instance()->text($string);
    }
}