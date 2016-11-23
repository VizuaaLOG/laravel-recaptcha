<?php

return [
    'sitekey' => env('RECAPTCHA_KEY', null),
    'secret' => env('RECAPTCHA_SECRET', null),
    'url' => env('RECAPTCHA_URL', 'https://www.google.com/recaptcha/api/siteverify'),
];