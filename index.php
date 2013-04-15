<?php
require 'klein.php';


/*******************************
 *          HEADER
 *******************************/

respond('*', function( $request, $response, $app ){
  $response->render('includes/header.html');
});

/*******************************
 *        STATIC ASSETS
 *******************************/

respond('@\.(js|css)$', function( $request, $response, $app ){

});


/*******************************
 *          ROUTES
 *******************************/


respond('/', function( $request, $response, $app ){
  $response->render('home.html');
});

respond('/home', function( $request, $response, $app ){
  $response->render('home.html');
});

respond('/portfolio', function( $request, $response, $app ){
  $response->render('portfolio.html');
});

respond('/about', function( $request, $response, $app ){
  $response->render('about.html');
});

respond('/skills', function( $request, $response, $app ){
  $response->render('skills.html');
});

respond('/resume', function( $request, $response, $app ){
  $response->render('resume.html');
});

respond('/contact', function( $request, $response, $app ){
  $response->render('contact.html');
});

respond('/blog', function( $request, $response, $app ){
  $response->render('blog/index.php');
});




/*******************************
 *          FOOTER
 *******************************/
respond('*', function( $request, $response, $app ){
  $response->render('includes/footer.html');
});

dispatch();
