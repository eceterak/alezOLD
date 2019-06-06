<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;
use Facades\Tests\Setup\AdvertFactory;
use Facades\Tests\Setup\ConversationFactory;

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function (Faker $faker) {

    $advert = AdvertFactory::create();

    return [
        'id' => Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\AdvertWasAdded',
        'notifiable_id' => function() {
            return auth()->id() ?: factory('App\User')->create()->id;
        },
        'notifiable_type' => 'App\User',
        'subject_type' => get_class($advert),
        'subject_id' => $advert->id,
        'data' => ['foo' => 'bar']
    ];
});


$factory->state(\Illuminate\Notifications\DatabaseNotification::class, 'conversation', function (Faker $faker) {
    
    $conversation = ConversationFactory::create();

    return [
        'id' => Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\AdvertWasAdded',
        'notifiable_id' => function() {
            return auth()->id() ?: factory('App\User')->create()->id;
        },
        'notifiable_type' => 'App\User',
        'subject_type' => get_class($conversation),
        'subject_id' => $conversation->id,
        'data' => ['foo' => 'bar']
    ];
});
