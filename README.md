# Laravel reCaptcha
If you have publically available forms, it may be a good idea to have some form of captcha. This will help reduce the amount of spam you receive from robots submitting that form.

reCaptcha is Googles take on captchas. Your user doesn't have to type out any hard to see text, instead, they may only need to simply click the checkbox. If the API is unsure as to whether that was a 'humanly' click then your user will be asked to do something involving pictures.

I regularly use reCaptcha in both my private and professional work. I also use Laravel. And it can be annoying having to type out the reCaptcha checking code. So Laravel reCaptcha was born.

## Installation
To install Laravel reCaptcha simple add it to your ```composer.json```:
```
"require": {
    ...
    "vizuaalog/laravel-recaptcha": "^1.0.0",
    ...
}
```

Alternatively add it via the composer CLI:
```
composer require vizuaalog/laravel-recaptcha
```

Then add the facade and provider to your ```config/app.php``` file within your Laravel app:
```
'providers' => [
    ...
    VizuaaLOG\Recaptcha\RecaptchaServiceProvider::class,   
    ...
],

'aliases' => [
    ...
    'Recaptcha' => VizuaaLOG\Recaptcha\Facades\RecaptchaFacade::class,
    ...
]
```

## Configuration
Before you can use Laravel reCaptcha you will first need to configure a sitekey and secret via [https://www.google.com/recaptcha/admin](the reCaptcha dashboard).

Once setup update your ```.env``` file to include the following:
```
RECAPTCHA_KEY=YourSiteKey
RECAPTCHA_SECRET=YourSiteSecret
```

## Usage
Within your form, you will need to render the reCaptcha box. You can do this by using the following method where you would like the box to show:
```
{!! Recaptcha::render() !!}
```

At the top of your controller you need to add a use statement to load in the `Recaptcha` facade, this is automatically registered via the `RecaptchaServiceController`.
```PHP
<?php

use Recaptcha;
...
```

Within your controller where your form posts you can use the following method to check if the captcha was successful. This returns a boolean value:
```PHP
if(Recaptcha::check($request)) {
    // Success
} else {
    // Fail
}
```

If the check fails you can access the errors received from the API using the following method, this returns an array of the errors:
```PHP
$errors = Recaptcha::getErrors();
```

Below is an example controller showing a potential 'real world' example.

```PHP
<?php

namespace App\Controllers;

use App\Post;
use Recaptcha;
use App\Http\Controllers\Controller;

class PostController extends Controller {
    // ... Your other methods above this
    public function store(Request $request, $id)
    {
        // Check to see if the captcha was completed
        if(!Recaptcha::check($request)) {
            return 'Captcha error: ' . Recaptcha::getErrors()[0];
        }

        Post::create($request->except(['_token', 'g-recaptcha-response']));

        return 'Completed';
    }
    // ... Your other methods below this
}
```

## Issues / contribution
If you notice any bugs, issues or would like the contribute to this project then please submit an issue or pull request detailing the bug or contribution.