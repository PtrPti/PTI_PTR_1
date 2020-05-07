<?php

use App\user;
use App\Message;
use App\Departamento;
use Illuminate\Suport\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Departamento::class, function (Faker $faker){
    return [
      'nome' => $faker->name,
      'cod_departamentos' => $faker->unique(true)->numberBetween(1, 30),    
    ];
});

$factory->define(App\User::class, function (Faker $faker) {
    static $password;   

    return [
        'nome' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'numero' => $faker->randomNumber,
        'data_nascimento' => $faker->dateTime('1461067200'),
        'perfil_id' => $faker->unique(true)->numberBetween(1, 2),
        'departamento_id' => $faker->unique(true)->numberBetween(1, 2),        
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Message::class, function (Faker $faker) {
    do{
      $from = rand(36,50);
      $to = rand(36, 50);
      $id_read= rand(0,1);
  
     } while($from === $to);
    return[
      'message'=> $faker->sentence,
      'id_read'=> $id_read,
      'from'=> $from,
      'to'=> $to    
    ];
});
  
?>