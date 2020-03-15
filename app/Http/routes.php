<?php 

use App\User;

get('/',["uses" => "HomeController@index"]);

get("/users", function(){
    return User::all();
});


?>