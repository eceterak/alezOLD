<?php

use Faker\Generator as Faker;

$factory->define(App\Photo::class, function (Faker $faker) {

    $file = Illuminate\Http\UploadedFile::fake()->image('photo.jpg');

    return [
        'url' => 'photos/'.$file->hashName()
    ];
});
