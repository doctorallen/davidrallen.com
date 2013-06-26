<?php
require_once __DIR__ .'/vendor/autoload.php';

$klein = new \Klein\Klein();


/*******************************
 *          HEADER
 *******************************/

$klein->respond('*', function( $request, $response, $service ){
	if(!array_key_exists('ajax', $request->params())){
	  $service->render('includes/header.html');
	}
});

/*******************************
 *        STATIC ASSETS
 *******************************/

$klein->respond('@\.(js|css)$', function( $request, $response, $service ){

});


/*******************************
 *          ROUTES
 *******************************/


$klein->respond('/', function( $request, $response, $service ){
  $service->render('home.html');
});

$klein->respond('/home', function( $request, $response, $service ){
  $service->render('home.html');
});

$klein->respond('/portfolio', function( $request, $response, $service ){
  $service->render('portfolio.html');
});

$klein->respond('/about', function( $request, $response, $service ){
  $service->render('about.html');
});

$klein->respond('/skills', function( $request, $response, $service ){
  $service->render('skills.html');
});

$klein->respond('/timeline', function( $request, $response, $service ){
  $service->render('timeline.html');
});

$klein->respond('/resume', function( $request, $response, $service ){
  $service->render('resume.html');
});

$klein->respond('/contact', function( $request, $response, $service ){
  $service->render('contact.html');
});

$klein->respond('/blog/*', function( $request, $response, $service ){
  $service->render('blog/index.php');
});



$klein->respond('404', function( $request, $response, $service ){
  $service->render('404.html');
});


/*******************************
 *          FOOTER
 *******************************/
$klein->respond('*', function( $request, $response, $service ){
	if(!array_key_exists('ajax', $request->params())){
	  $service->render('includes/footer.html');
	}
});

$klein->dispatch();
