<?php

namespace Kings\Press\Repositories;

use Kings\Press\Models\Post;

use Kings\Press\Traits\RandFuncs;

use Kings\Press\Facades\Press;

class PostRepository
{
    use RandFuncs;
    public function save($post, $key)
    {
        //dd($post);
        Post::updateOrCreate(
            [
      "identifier"=> $this->slug($key)
    ],
            [
      'slug' => $this->slug($post['title']),
      'title'=> $post['title'],
      'body' => $post['body'],
      'extra' => $this->extra($post), //isset($post['extra']) ? json_encode($post['extra']) : ''
    ]
        );
    }

    protected function extra($post)
    {
        $extra = (array)json_decode($post['extra'] ?? '[]');
        //dd(Press::getRegisteredFields());
        $attributes = $this->arrayExclude($post, ['title','body','identifier','extra']);

        return json_encode(array_merge($extra, $attributes));
    }
}
