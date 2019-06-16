<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Photo::class, function (Faker $faker) {

    $file = Illuminate\Http\UploadedFile::fake()->image('photo.jpg');

    return [
        'url' => 'photos/'.$file->hashName(),
        'temp' => Str::uuid()->toString()
    ];
});
