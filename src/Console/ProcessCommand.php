<?php

 namespace Kings\Press\Console;

 use Illuminate\Console\Command;

 use Kings\Press\Models\Post;

 use Kings\Press\Traits\RandFuncs;

 use Kings\Press\Facades\Press;

 use Kings\Press\Repositories\PostRepository;

 class ProcessCommand extends Command
 {
     protected $signature = 'press:process';

     protected $description = 'Updates blog posts';

     use RandFuncs;
     /**
      * Create a new command instance.
      *
      * @return void
      */
     public function __construct()
     {
         parent::__construct();
     }

     public function handle(PostRepository $postRepo)
     {
         if (Press::configNotPublished()) {
             return $this->warn('Please publish config file by running,'.
              '\'php artisan vendor:publish --tag=press-config\'');
         }
         // fetch all the posts from directory.
         try {
             $posts = Press::driver()->fetchPosts();
             $this->info('Number of Posts: '.count($posts));
             //dd($posts);
             if (count($posts)):
               foreach ($posts as $key=>$post):
                  $this->info('Processing post with title '.$post['title']);
             $postRepo->save($post, $key);
             endforeach; else :
                $this->info('No pose to process');
             endif;
         } catch (\Exception $e) {
             $this->error($e->getMessage());
         }


         //persist to the DB
     }
 }
