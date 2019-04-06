<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('/start', function ($bot) {
	$nombres = $bot->getUser()->getFirstName() ?: "desconocido";
	$bot->reply('Hola ' . $nombres . ', bienvenido al bot SimpleQuizzes!');
});

$botman->fallback(function ($bot) {
	$bot->reply('No entiendo que quieres decir, vuelve a intentarlo.');
});

$botman->hears('/ayuda', function ($bot) {
	$ayuda = ['/ayuda' => 'Mostrar este mensaje de ayuda',
          	'acerca de|acerca' => 'Ver la información quien desarrollo este lindo bot',
          	'listar quizzes|listar' => 'Listar los cuestionarios disponibles',
          	'iniciar quiz <id>' => 'Iniciar la solución de un cuestionario',
          	'ver puntajes|puntajes' => 'Ver los últimos puntajes',
          	'borrar mis datos|borrar' => 'Borrar mis datos del sistema'];
    
	$bot->reply("Los comandos disponibles son:");

	foreach($ayuda as $key=>$value)
	{
    		$bot->reply($key . ": " . $value);
	}
});

$botman->hears('acerca de|acerca', function ($bot) {
	$msj = "Este bot de charla fue desarrollado por:\n".
       	 "Danela Mideros Ospina <daniela.mideroso@autonoma.edu.co>\n".
       	 "Durante la clase de Procesos Ágiles\n".
       	 "de la Universidad Autónoma de Manizales.";

	$bot->reply($msj);
});


$botman->hears('listar quizzes|listar', function ($bot) {
	$quizzes = \App\Quiz::orderby('titulo', 'asc')->get();

	foreach($quizzes as $quiz)
	{
    		$bot->reply($quiz->id."- ".$quiz->titulo);
	}

	if(count($quizzes) == 0)
    		$bot->reply("Ups, no hay cuestionarios para mostrar.");
});

