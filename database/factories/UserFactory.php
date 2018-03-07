<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
	$emails = [
		'@sahum.gob.ve',
		'@gmail.com',
		'@hotmail.com',
		'@outlook.com',
		'@yahoo.com',
		'@mail.com'
	];
	$name = $faker->firstName;
	$user = $faker->bothify($name.'#?##?');
	return [
		'user' => $user,
		'name' => $name,
		'last_name' => $faker->lastName,
		'num_id' => rand(500000, 50000000),
		'email' => $user.$emails[rand(0, 5)],
		'password' => bcrypt('secret'),
		'remember_token' => str_random(10),
		'module_id' => rand(1, 3)
	];
});

$factory->define(App\Models\Permisologia\Role::class, function (Faker $faker) {
	$rol = $faker->numerify('Rol n°  ####');
	return [
		'name' => $rol,
		'slug' => $rol,
		'description' => 'Rol de prueba',
		'from_at' => \Carbon\Carbon::parse('08:00:00'),
		'to_at' => \Carbon\Carbon::parse('17:00:00'),
		'special' => null
	];
});