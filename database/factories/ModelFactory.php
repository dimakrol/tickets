<?php

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
use Carbon\Carbon;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Concert::class, function (Faker\Generator $faker) {

    return [
        'title' => 'The Red Chord',
        'subtitle' => 'Some cool subtitle',
        'date' => Carbon::parse('+2 weeks'),
        'ticket_price' => 3250,
        'venue' => 'The Mosh Pit',
        'venue_address' => '123 Example',
        'city' => 'Bludville',
        'state' => 'ON',
        'zip' => '1796',
        'additional_information' => 'For tickets, call (555) 555-5555.'
    ];
});

$factory->state(App\Concert::class, 'published', function($faker) {
    return [
        'published_at' => Carbon::parse('-1 week')
    ];
});

$factory->state(App\Concert::class, 'unpublished', function($faker) {
    return [
        'published_at' => null
    ];
});