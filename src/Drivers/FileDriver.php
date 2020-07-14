<?php

namespace Kings\Press\Drivers;

use Illuminate\Support\Facades\File;

use Kings\Press\PressFileParser;

use Kings\Press\Drivers\Driver;

use Kings\Press\Exceptions\FileDriverDirectoryNotFoundException;

class FileDriver extends Driver
{
    public function fetchPosts()
    {
        $files = File::files($this->config['path']);
        foreach ($files as $file) {
            $this->parse($file->getPathname(), $file->getFilename());//(new PressFileParser($file))->getData();
        }

        return $this->posts;
    }

    protected function validateSource()
    {
        if (!File::exists($this->config['path'])) {
            throw new FileDriverDirectoryNotFoundException(
                'Directory at \''.$this->config['path'].'\' dose not exist. Check the direcory'.
            'path in the config file \''
            );
        }
    }
}
