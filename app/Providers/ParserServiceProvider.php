<?php

namespace App\Providers;

use App\Services\ParserService\ParserInterface;
use Illuminate\Support\ServiceProvider;

class ParserServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $parserCode = config('parsing.default', 'kartoteka');
        $parserClass = config("parsing.parsers.$parserCode.class");
        $parserUrl = config("parsing.parsers.$parserCode.url");

        $this->app->bind(ParserInterface::class, fn($app) => (new $parserClass())->initUrl($parserUrl));
    }
}
