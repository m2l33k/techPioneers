<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    $context['OPENAI_API_KEY'] = getenv('OPENAI_API_KEY');
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
