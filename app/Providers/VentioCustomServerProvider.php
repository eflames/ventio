<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class VentioCustomServerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('search', function ($attributes, string $searchTerm) {
            $searchTerm = Str::replaceFirst(' ','%', $searchTerm);
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                }
            });
            return $this;
        });
    }
}
