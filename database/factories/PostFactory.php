<?php

use Kings\Press\Models\Post;

use Faker\Generator as Faker;


$factory->define(Post::class,function(Faker $faker){
    return [
      'identifier' => quickRandom(),
      'slug'=> slug($faker->sentence),
        //'slug'=> slug('@fu kat# tanklop.'),
      'title' => $faker->sentence,
      'body' => $faker->paragraph,
      'extra'=>json_encode(['test'=>'value'])
    ];
});
