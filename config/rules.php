<?php

return [
    ['class' => 'yii\rest\UrlRule', 'controller' => 'user'],
    ['class' => 'yii\rest\UrlRule','controller' => 'photo'],
    ['class' => 'yii\rest\UrlRule','controller' => 'versus'],
    ['class' => 'yii\rest\UrlRule','controller' => 'facemash'],
    '<controller:user>/<action:add-girl>' => 'user/add-girl',
    '<controller:versus>/<action:set-new-like>' => 'versus/set-new-like',
    '<controller:photo>/<action:get-photos>' => 'photo/get-photos',
    '<controller:photo>/<action:get-rating>' => 'photo/get-rating',
    '<controller:versus>/<action:clear-votes>' => 'versus/clear-votes',
    '<controller:photo>/<action:clear-persons>' => 'photo/clear-persons',
    '<controller:facemash>/<action:get-facemashes>' => 'facemash/get-facemashes',
    '<controller:facemash>/<action:create-facemash>' => 'facemash/create-facemash',
    '<controller:facemash>/<action:edit-facemash>' => 'facemash/edit-facemash',
    '<controller:facemash>/<action:delete-facemash>' => 'facemash/delete-facemash'
];
