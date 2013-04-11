<?php
require 'klein.php';


/*******************************
 *          HEADER
 *******************************/

respond('*', function( $request, $response, $app ){
  $response->render('includes/header.html');
});

/*******************************
 *          ROUTES
 *******************************/

respond('@\.(js|css)$', function( $request, $response, $app ){

});


/*******************************
 *          ROUTES
 *******************************/


respond('/', function( $request, $response, $app ){
  $response->render('home.php');
});

respond('/home', function( $request, $response, $app ){
  $response->render('home.php');
});

respond('/portfolio', function( $request, $response, $app ){
  $response->render('portfolio.php');
});

respond('/about', function( $request, $response, $app ){
  $response->render('about.php');
});

respond('/resume', function( $request, $response, $app ){
  $response->render('resume.php');
});

respond('/contact', function( $request, $response, $app ){
  $response->render('contact.php');
});




/*******************************
 *          FOOTER
 *******************************/
respond('*', function( $request, $response, $app ){
  $response->render('includes/footer.html');
});

dispatch();
