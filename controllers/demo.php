<?php

// SLIME-TEST components at end


  use Slime\render;
  use VPHP\http;
  use VPHP\cookie;
  use VPHP\db;
  use VPHP\x;



  // single custom helper
  // https://zordius.github.io/HandlebarsCookbook/0021-customhelper.html
  $GLOBALS['hbars_helpers']['qual'] = function ($arg1, $arg2) {
    return ($arg1 === $arg2) ? 'Yes' : 'No';
  };



// fixit get this to work

// similar problem here - https://github.com/zordius/lightncandy/issues/287
// custom if here - https://github.com/zordius/lightncandy/issues/213 ***

// ?? other helpers / options for doing more advanced comparison logic
  // https://zordius.github.io/HandlebarsCookbook/
  // https://zordius.github.io/HandlebarsCookbook/9002-helperoptions.html

// ?? https://www.google.com/search?q=lightncandy+custom+block+helper+xif+logic&oq=lightncandy+custom+block+helper+xif+logic&aqs=chrome..69i57j33i10i160.10726j0j1&sourceid=chrome&ie=UTF-8

  // may need to add flags in render/compile function? - /Users/jy/Desktop/projects/slime-demo/vendor/hxgf/slime-utilities/src/render.php

// can we use subexpression instead? - https://zordius.github.io/HandlebarsCookbook/0026-subexpression.html
  // w/ flag FLAG_ADVARNAME




  // IT WORKS NOW !!
  // WOW
  $GLOBALS['hbars_helpers']['is'] = function ($l, $operator, $r, $options) {

    if ($operator == '=='){
      $condition = ($l == $r);
    }
    if ($operator == '==='){
      $condition = ($l === $r);
    }
    if ($operator == 'not' || $operator == '!='){
      $condition = ($l != $r);
    }	
    if ($operator == '<'){
      $condition = ($l < $r);
    }
    if ($operator == '>'){
      $condition = ($l > $r);
    }
    if ($operator == '<='){
      $condition = ($l <= $r);
    }
    if ($operator == '>='){
      $condition = ($l >= $r);
    }
    if ($operator == 'in'){
      if (gettype($r) == 'array'){
        $condition = (in_array($l, $r));
      }else{
        // expects a csv string
        $condition = (in_array($l, str_getcsv($r)));
      }
    }
    if ($operator == 'typeof'){
      $condition = (gettype($l) == gettype($r));
    }
    // print_r([$l, $operator, $r]);
    // echo $condition;
    // return $condition;

    // $exp = explode('{{else}}', $categories);

    if ($condition){
      return $options['fn']();
    }else{
      return $options['inverse']();
    }

    // echo $options['hash'];

    // return $options['fn']($condition);

  };      




  $GLOBALS['hbars_helpers']['xif'] = function ($expression, $options) {

    // echo $expression;

		if (eval($expression)) { // => Unfortunately, this line will generate an error :-(
			return $options['fn']();
		} else {
			return $options['inverse']();
		}

    print_r($options);
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




  $app->get('/header-demo[/]', function ($req, $res, $args) {

    return $res->withHeader('Location', '/')->withStatus(302);

  });

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
      'layout' => '_layouts/base-tachyons',
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
        'layout' => '_layouts/base-tachyons',
        'title' => 'Hello, ' . $args['name'] . '! - ' . $GLOBALS['site_title'],
        'data' => [
          'name' => $args['name'],
        ]
      ]);

  });






  $app->get('/json-response[/]', function ($req, $res, $args) {

    return render::json($req, $res, $GLOBALS['hello']);

  });













// WE DONT DO THIS ANYMORE

  // if you want to use twig, make sure slim twig view is installed:
  // composer require slim/twig-view

  // $app->get('/twig', function ($req, $res, $args) {

  //   return render::twig($req, $res, [
  //     'template' => 'demo-twig',
  //     'layout' => '_layouts/base-twig',
  //     'title' => 'SLIME Twig Demo - ' . $GLOBALS['site_title'],
  //     'data' => [
  //       'first' => 123,
  //       'second' => 456,
  //       'hello' => $GLOBALS['hello'],
  //       'api_response' => http::json('/json-reponse', ['method' => 'GET']),
  //       'test_cookie' => cookie::get('test-cookie'),
  //       'slug_demo' => x::url_slug('This is A Log string!!!'),
  //       'client_ip' => x::client_ip()
  //     ],
  //   ]);

  // });













































  // for slime-test
// $GLOBALS['settings']['database'] = [
//   'host' => 'localhost',
//   'name' => 'purhost_slime_demo',
//   'user' => 'purhost_slime_demo',
//   'password' => '0000w...'
// ];


// from slime-test


// $home = function ($req, $res, $args) {

// // DONE

//  // return render::redirect($req, $res, 'https://google.com');


// // DONE

// // $articles = db::get("articles", "_id IS NOT NULL");
// // print_r($articles);



// // DONE
// // x::console_log(['$articles' => 'what'], [
// //   'style' => [
// //     'font-size' => '16px',
// //     'background' => 'blue',
// //     'color' => 'yellow',
// //     'padding' => '2.5rem',
// //     'line-height' => '200%',
// //     'custom' => 'font-style: italic'
// //   ]
// //   // 'format' => false
// // ]);


// // DONE
// // x::file_write('what something', 'data.txt', [
// //   // 'mode' => 'w+',
// //   'line_beginning' => "\n- ",
// //   'line_ending' => "",
// //   // 'line_ending' => "\n\n\n",
// // ]);


// // DONE
// // x::file_write([
// //   'an_array' => 'is great',
// //   'ok' => [
// //     'this is' => 'awesome'
// //   ]
// // ], 'data.txt');



// // DONE
// // $var = [
// //   'what' => 'idk'
// // ];
// // x::dd($var, [
// //   'format' => false
// // ]);




// // DONE
// // x::error_log('ERROR: YOU ARE A PIECE OF SHIT');

// // x::error_log(['whatever' => 'jennifer']);







// // DONE

// // $url = "https://reqbin.com/echo";

// // $curl = curl_init($url);
// // curl_setopt($curl, CURLOPT_URL, $url);
// // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// // $headers = array(
// //    "Accept: */*",
// // );
// // curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
// // //for debug only!
// // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
// // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

// // $resp = curl_exec($curl);
// // curl_close($curl);
// // var_dump($resp);








// // DONE


// // $curl = curl_init();

// // curl_setopt_array($curl, array(
// //   CURLOPT_URL => "http://picbear.com/tag/ok",
// //   CURLOPT_RETURNTRANSFER => true,
// //   CURLOPT_ENCODING => "",
// //   CURLOPT_MAXREDIRS => 10,
// //   CURLOPT_TIMEOUT => 30,
// //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// //   CURLOPT_CUSTOMREQUEST => "GET",
// //   CURLOPT_HTTPHEADER => array(
// //     "cache-control: no-cache",
// //     "user-agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36" // Here we add the header
// //   ),

// // ));

// // $response = curl_exec($curl);
// // $err = curl_error($curl);

// // curl_close($curl);

// // if ($err) {
// //   echo "cURL Error #:" . $err;
// // } else {
// //   echo $response;
// // }


// // echo "<hr />";






// // DONE

// // $url = 'https://httpbin.org/post';
// // // $url = 'https://httpbin.org/get';
// // // $url = 'https://reqbin.com/echo/get/xml';
// // // $url = 'https://oceancompaniesok.com';
// // // $url = 'https://slime.hxgf.io/';
// // // $url = 'https://httpbin.org/post';
// // // $url = 'https://jsonplaceholder.typicode.com/posts';

// //     $data_slideshow = http::request($url, [
// //       'method' => 'POST',
// //       'json_decode' => true,
// //       // 'debug' => true,
// //       'data' => [
// //         'what' => 'idk',
// //         'really' => 'yes',
// //         'ok' => 'wow'
// //       ],
// //           'headers' => [
// //             // 'Content-length' => 0,
// //             // 'Content-Type' => 'application/json',
// //             // 'Accept' => '*/*'
// //             // 'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36'
// //           ]
// //     ]);
// //     echo "<pre class='f6'>";
// //     print_r($data_slideshow);
// //     echo "</pre>";




// // DONE


//   // cookie::set('what', 'idk', [
//   //   // 'expires' => time() + 86400
//   //   'expires' => time() + 86400,
//   //   // 'path' => '/bob/',
//   //   // 'domain' => 'bpb.purhost.net',
//   //   'secure' => true,
//   //   'httponly' => true,
//   //   'samesite' => 'Strict',
//   //   // 'samesite' => 'lax',
//   //   // 'samesite' => 'None',
//   // ]);




//   return render::hbs($req, $res, [
//     'layout' => '_layouts/base',
//     'template' => 'index',
//     'title' => $GLOBALS['site_title'],
//   ]);

// };





// $app->get('/', $home);
// $app->get('/bob[/]', $home);






  $app->get('/html-demo', function ($req, $res, $args) {

    $html = '<h2>hey whats up</h2>';

    return render::html($req, $res, $html);
  });









  $app->get('/resend-demo', function ($req, $res, $args) {


	function email_resend($input){

    $resend_api_key = '';

    $message_html = false;
		if (isset($input['html'])){
      $message_html = $input['message'];					
			$message_text = strip_tags(x::br2nl($message_html));	
		}
		// if (isset($GLOBALS['settings']['mailgun']['api_key'])){


      $message = array(
				'from' => $input['from'],
				'to' => $input['to'],
				'subject' => $input['subject']
			);
			// if (isset($input['cc'])){
			// 	$message['cc'] = $input['cc'];
			// }	
			// if (isset($input['reply_to'])){
			// 	$message['h:Reply-To'] = $input['reply_to'];
			// }
			// if (isset($input['bcc'])){
			// 	$message['bcc'] = $input['bcc'];
			// }	
			if ($message_html){
				$message['html'] = $message_html;
				$message['text'] = $message_text;
			}else{
				$message['text'] = $input['message'];
			}
			// if (isset($input['preview'])){
			// 	echo $message;
			// }
			// if (isset($input['debug'])){
			// 	echo '<pre class="bg-black white">';
			// 	print_r($input);
			// 	echo "<hr />";
			// 	echo $headers;
			// 	echo "<hr />";
			// 	echo $message;
			// 	echo '</pre>';
			// }
			if (isset($input['to']) && !isset($input['preview']) && !isset($input['debug'])){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.resend.com/email");
        // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($ch, CURLOPT_USERPWD, "api:".$GLOBALS['settings']['mailgun']['api_key']."");
        $headers = [];
        $headers[] = 'Authorization: Bearer ' . $resend_api_key;
        $headers[] = 'Content-Type: application/json';
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_POST, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    //   }else{
		// 		return false;
    //   }
		// }
		// else{
		// 	if ($message_html){
		// 		$boundary = uniqid('st');
		// 		$headers .= "MIME-Version: 1.0\r\n" . "Content-type: multipart/alternative; boundary=" . $boundary . "; charset=utf-8\r\n";
		// 		$message = $message_text;
		// 		$message .= "\r\n\r\n--" . $boundary . "\r\n";
		// 		$message .= "Content-type: text/plain;charset=utf-8\r\n\r\n" . $message_text;
		// 		$message .= "\r\n\r\n--" . $boundary . "\r\n";
		// 		$message .= "Content-type: text/html;charset=utf-8\r\n\r\n" . $message_html;
		// 		$message .= "\r\n\r\n--" . $boundary . "--";
		// 	}else{
		// 		$message = $input['message'];
		// 	}
		// 	if (isset($input['from'])){
		// 		$headers 	.= "From: " . $input['from'] . "\r\n";	
		// 	}		
		// 	if (isset($input['cc'])){
		// 		$headers 	.= "Cc: " . $input['cc'] . "\r\n";	
		// 	}		
		// 	if (isset($input['bcc'])){
		// 		$headers 	.= "Bcc: " . $input['bcc'] . "\r\n";	
		// 	}		
		// 	if (isset($input['reply_to'])){
		// 		$headers 	.= "Reply-To: " . $input['reply_to'] . "\r\n";	
		// 	}
		// 	if (isset($input['preview'])){
		// 		echo $message;
		// 	}
		// 	if (isset($input['debug'])){
		// 		echo '<pre class="bg-black white">';
		// 		print_r($input);
		// 		echo "<hr />";
		// 		echo $headers;
		// 		echo "<hr />";
		// 		echo $message;
		// 		echo '</pre>';
		// 	}
		// 	if (isset($input['to']) && !isset($input['preview']) && !isset($input['debug'])){
		// 		mail($input['to'], $input['subject'], $message, $headers);
		// 		return true;
		// 	}else{
		// 		return false;
		// 	}
		}
	}



    $resend = email_resend(array(
      'to' => 'jonathan.youngblood@gmail.com',
    	'from' => 'ME <notifications@resend.purhost.net>',
    	'subject' => 'Hella World',
      'html' => true,
      'message' => '<img src="https://i.pinimg.com/736x/69/07/4b/69074bc0871256c45ac834cb15f8df8e.jpg" /> <br /><br /><h1>sweet little baby</h1>',

    ));

    x::console_log($resend);

    return render::json($req, $res, [
      'email' => 'resemt',
      'data' => $GLOBALS['hello']
    ]);


  });




?>