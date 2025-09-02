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
    $router->post('/registrarJugadoresEquipos', 'Equipos\EquiposController@registrarJugadoresEquipos');
});

$router->group(['prefix' => 'grupos'], function () use ($router) {
    $router->get('/agregar', 'Grupos\GruposController@crearGrupos');
   
});


$router->group(['prefix' => 'jugadores'], function () use ($router) {
    $router->get('/', 'Jugadores\JugadoresController@index');
});
$router->group(['prefix' => 'posiciones'], function () use ($router) {
    $router->get('/', 'Posiciones\PosicionesController@Posiciones');
    $router->post('/jornada/', 'Posiciones\PosicionesController@Posiciones_Jornada');
});
$router->group(['prefix' => 'resultados'], function () use ($router) {
    $router->get('/', 'Resultados\ResultadosController@index');
    $router->get('/{id}', 'Resultados\ResultadosController@index');
    $router->post('/Categoria', 'Resultados\ResultadosController@ResultadosJornada');
    $router->post('/Registrar', 'Resultados\ResultadosController@RegistrarResultados');
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

$router->group(['prefix' => 'juegos'], function () use ($router) {
    $router->get('/', 'Juegos\JuegosController@index');
    $router->get('mach/{id}', 'Juegos\JuegosController@index');

    $router->get('/crearJuegos', 'Juegos\JuegosController@crearJuegos');
    $router->post('/registrarJuegos', 'Juegos\JuegosController@registrarJuegos');
}); 


$router->group(['prefix' => 'Jornadas'], function () use ($router) {
    // $router->get('/', 'Categoria\CategoriasController@Categorias');

    $router->get('/', 'Jornadas\JornadasController@ListaJornadas');
    $router->post('/listarJornadas', 'Jornadas\JornadasController@listarJornadas');
    $router->post('/modificarJornadas', 'Jornadas\JornadasController@modificarJornadas');
});

$router->group(['prefix' => 'image'], function () use ($router) {
    $router->get('/', 'image\imagenController@ImageJugadores');
});
