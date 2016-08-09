<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HtmlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       \Form::component('bsText',   'components.form.text',   ['name', 'label' => null, 'value' => null, 'attributes' => []]);
       \Form::component('bsSubmit', 'components.form.submit', ['label' => null, ]);
       \Form::component('bsSelect', 'components.form.select', ['name', 'default', 'label' => null, 'data' => []]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
