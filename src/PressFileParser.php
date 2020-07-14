<?php

namespace Kings\Press;

use Illuminate\Support\Facades\File;
use Kings\Press\MarkdownParser;
use Carbon\Carbon;

class PressFileParser
{
    protected $fileName;
    protected $data;
    protected $rawData;
    public function __construct($file)
    {
        $this->fileName = $file;
        $this->splitFile();
        $this->explodeData();
        $this->processFields();
    }

    public function getData()
    {
        return $this->data;
    }

    public function getRawData()
    {
        return $this->rawData;
    }

    protected function splitFile()
    {
        $pattern = '/^\-{3}(.*?)\-{3}(.*)/s';
        $content = File::exists($this->fileName) ? File::get($this->fileName):$this->fileName;
        //dd($content);
        preg_match('/^\-{3}(.*?)\-{3}(.*)/s',
            $content,
            $this->rawData);

        //dd($this->data);
    }

    protected function explodeData()
    {
        $fields = (explode("\n",trim($this->rawData[1])));
        //dd($fields);
        if(count($this->rawData)):
            foreach($fields as $fieldString){
                preg_match('/(.*):\s*(.*)/', $fieldString, $field_array);
                $this->data[$field_array[1]] = $field_array[2];
            }
            $this->data['body'] = trim($this->rawData[2]);
        endif;
        //dd($this->data);

    }

    protected function processFields()
    {
        foreach($this->data as $field => $value){

            $class = "Kings\\Press\\Fields\\".ucfirst($field);
            if(!class_exists($class) && !method_exists($class,'process')){
                $class = "Kings\\Press\\Fields\\Extra";
            }
            $this->data = array_merge($this->data,$class::process($field,$value,$this->data));
        }
        //dd($this->data);
    }

}