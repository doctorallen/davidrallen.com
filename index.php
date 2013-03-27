<?php
require 'klein.php';

respond('*', function( $request, $response, $app ){
  $response->render('includes/header.html');
});

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

respond('/development', function( $request, $response, $app ){
  $response->render('development.php');
});

respond('*', function( $request, $response, $app ){
  $response->render('includes/footer.html');
});

dispatch();
