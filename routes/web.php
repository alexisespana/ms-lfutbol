<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'equipos'], function () use ($router) {
    $router->get('/', 'Equipos\EquiposController@index');
    $router->post('/crearEquipos', 'Equipos\EquiposController@CrearEquipos');
    $router->post('/editarEquipos', 'Equipos\EquiposController@editarEquipos');

   
});

$router->group(['prefix' => 'juegos'], function () use ($router) {
    $router->get('/', 'Juegos\JuegosController@index');
   
});
$router->group(['prefix' => 'jugadores'], function () use ($router) {
    $router->get('/', 'Jugadores\JugadoresController@index');
   
});
$router->group(['prefix' => 'posiciones'], function () use ($router) {
    $router->get('/', 'Posiciones\PosicionesController@Posiciones');
   
});
$router->group(['prefix' => 'resultados'], function () use ($router) {
    $router->get('/', 'Resultados\ResultadosController@index');
    $router->get('/{id}', 'Resultados\ResultadosController@index');
    $router->post('/Categoria/', 'Resultados\ResultadosController@ResultadosJornada');
   
});
$router->group(['prefix' => 'goleadores'], function () use ($router) {
    $router->get('/', 'Goleadores\GoleadoresController@TablaGoleadores');
   
});
$router->group(['prefix' => 'noticias'], function () use ($router) {
    $router->get('/noticiasJornada', 'NoticiasJornada\NoticiasJornadaController@NoticiasJornada');
});
$router->group(['prefix' => 'categorias'], function () use ($router) {
    $router->get('/', 'Categoria\CategoriasController@Categorias');
    $router->post('/crearCategoria', 'Categoria\CategoriasController@crearCateogorias');
    $router->post('/editarCategoria', 'Categoria\CategoriasController@editarCategoria');
    $router->post('/deleteCategoria', 'Categoria\CategoriasController@deleteCategoria');
});

$router->group(['prefix' => 'image'], function () use ($router) {
    $router->get('/', 'image\imagenController@ImageJugadores');
});
