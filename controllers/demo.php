<?php

  use Slime\render;
  use Slime\http;
  use Slime\cookie;
  use Slime\db;
  use Slime\x;



  // single custom helper
  // https://zordius.github.io/HandlebarsCookbook/0021-customhelper.html
  $GLOBALS['hbars_helpers']['isequal'] = function ($arg1, $arg2) {
    return ($arg1 === $arg2) ? 'Yes' : 'No';
  };


  // custom block helper
  // https://zordius.github.io/HandlebarsCookbook/0022-blockhelper.html
  $GLOBALS['hbars_helpers']['myloop'] = function ($arg1, $options) {
    return $options['fn']($arg1);
  };



  $GLOBALS['hello'] = [
    ['name' => 'Dolly', 'location' => 'San Francisco'], 
    ['name' => 'Kitty', 'location' => 'Dallas'], 
    ['name' => 'Cleveland', 'location' => 'Ohio'], 
    ['name' => 'Fresh', 'location' => 'Bucharest'], 
    ['name' => 'Mother', 'location' => 'Boston'],
    ['name' => 'J-bird', 'location' => 'Algarve'],
    ['name' => 'Goodbye', 'location' => 'In Your Arms']
  ];





  $app->get('/demo[/]', function ($req, $res, $args) {

    // $db_query = db::find("developments", "shortcode != 'mst' ORDER BY title ASC");

    // print_r($db_query);


    // db::update('debug', [
    //   'test' => 'f1rst oneasdasdasdasd'
    // ], "id='6'");

    // db::insert('debug', [
    //   'test' => 'ok hi from slime!!!!'
    // ]);

    // db::delete('debug', "id='6'");


    // $data_slideshow = http::request('https://jsonplaceholder.typicode.com/posts', [
    //   'method' => 'GET',
    //   'format' => 'json'
    // ]);
    // print_r($data_slideshow);

    // $data_slideshow = http::json('https://api.example.com/v1/request/demo');

    // $data_slideshow = http::get('https://api.example.com/v1/request/demo');

    // $data_slideshow = http::post('https://api.example.com/v1/request/demo', [
    //   'data' => [
    //     'shortcode' => 'TR'
    //   ]
    // ]);



    // cookie::set('test-cookie', 'hey whats up');
    // echo cookie::get('test-cookie');

    // cookie::delete('test-cookie');
    


    // x::email_send(array(
    //   'to' => 'jonathan.youngblood@gmail.com',
    // 	'from' => 'Ocean Management <notifications@oceancompaniesok.com>',
    // 	'subject' => 'Welcome to your Ocean Management tenant portal!',
    //   'html' => true,
    //   'message' => 'hey this is sent using the slime abstraction function.<br /><br /> it\'s the same function from stereo, but modified to work with slim. <br /><br /> it was super easy! pretty cool! <br /><br /> I LOVE PHP :)',
    //   // fixit make this work
    // 	// 'template' => 'email/welcome-tenant',
    // 	// 'data' => array(
    // 	// 	'first_name' => $user['first_name'],
    // 	// 	'email' => $user['email'],
    // 	// 	'pwr' => base64_decode($user['pwr'])
    // 	// ),
    // ));

    // $GLOBALS['locals']['auth'] = true;


    return render::hbs($req, $res, [
      'template' => 'demo',
      'layout' => '_layouts/base',
      'title' => 'SLIME HBS Demo - ' . $GLOBALS['site_title'],
      'data' => [
        'name' => 'rayne - the vampire who kills vampires',
        'foo' => 'cleveland ... i\'m amazed that this works',
        'bar' => 2,
        'first' => 123,
        'second' => 456,
        'hello' => $GLOBALS['hello'],
        // 'db_query' => $db_query['data'],
        'api_response' => http::json('/json-reponse', ['method' => 'GET']),
        'test_cookie' => cookie::get('test-cookie'),
        'slug_demo' => x::url_slug('This is A Long string!!!'),
        'client_ip' => x::client_ip(),
        'slime_links' => [
          'https://github.com/hxgf/slime-utilities',
          'https://github.com/hxgf/slime-render',
          'https://github.com/hxgf/dbkit',
          'https://github.com/hxgf/http-request',
          'https://github.com/hxgf/cookie',
          'https://github.com/hxgf/x-utilities'
        ]
      ],
    ]);

  });










  $app->get('/hello/{name}[/]', function ($req, $res, $args) {
    
      return render::hbs($req, $res, [
        'template' => 'hello',
        'layout' => '_layouts/base',
        'title' => 'Hello, ' . $args['name'] . '! - ' . $GLOBALS['site_title'],
        'data' => [
          'name' => $args['name'],
        ]
      ]);

  });






  $app->get('/json-response[/]', function ($req, $res, $args) {

    return render::json($req, $res, [
      'data' => $GLOBALS['hello']
    ]);

  });















  // if you want to use twig, make sure slim twig view is installed:
  // composer require slim/twig-view

  $app->get('/twig', function ($req, $res, $args) {

    return render::twig($req, $res, [
      'template' => 'demo-twig',
      'layout' => '_layouts/base-twig',
      'title' => 'SLIME Twig Demo - ' . $GLOBALS['site_title'],
      'data' => [
        'first' => 123,
        'second' => 456,
        'hello' => $GLOBALS['hello'],
        'api_response' => http::json('/json-reponse', ['method' => 'GET']),
        'test_cookie' => cookie::get('test-cookie'),
        'slug_demo' => x::url_slug('This is A Log string!!!'),
        'client_ip' => x::client_ip()
      ],
    ]);

  });





?>