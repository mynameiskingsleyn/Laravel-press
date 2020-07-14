<?php

return [

  /**
  * Set default driver; default is file
  */
  'driver'=>'file', // default driver
  /**
  * url path
  */
  'path' => 'press',
  'drivers' =>[
    'file'=>[
      'path'=>'blogs'
    ],

    'database'=>[
      'table_name' =>''
    ]
  ]
];
