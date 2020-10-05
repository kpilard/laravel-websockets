<?php

namespace BeyondCode\LaravelWebSockets\Database\Console;

use Illuminate\Console\Command;
use BeyondCode\LaravelWebSockets\Database\Models\App;

class AppCreate extends Command
{
    protected $signature = 'websockets:app:create
        {--name=}
        {--host=}
        {--no-host}
        {--enable-client-messages}
        {--disable-client-messages}
        {--enable-statistics}
        {--disable-statistics}
    ';

    protected $description = 'Create an app and save it on database.';

    public function handle()
    {

        if ($this->option('name')) {
            $name = $this->option('name');
        } else {
            $name = $this->ask('What is the app name? (required)');
        }

        if (empty($name)) {
            $this->handle();

            return;
        }

        if ($this->option('host')) {
            $host = $this->option('host');
        } else if($this->option('no-host')) {
            $host = null;
        } else {
            $host = $this->ask('Host');
        }

        if ($this->option('enable-client-messages')) {
            $enable_client_messages = true;
        } else if($this->option('disable-client-messages')) {
            $enable_client_messages = false;
        } else {
            $enable_client_messages = $this->confirm('Would you enable client messages?');
        }

        if ($this->option('enable-statistics')) {
            $enable_statistics = true;
        } else if($this->option('disable-statistics')) {
            $enable_statistics = false;
        } else {
            $enable_statistics = $this->confirm('Would you enable statistics?');
        }

        $this->comment('Creating your application, please wait...');

        $app = App::create([
            'name' => $name,
            'host' => $host,
            'enable_client_messages' => $enable_client_messages,
            'enable_statistics' => $enable_statistics,
        ]);

        $this->info('Id: '.$app->id);
        $this->info('Key: '.$app->key);
        $this->info('Secret: '.$app->secret);

        $this->comment('App has been created. Please save key and secret.');
    }
}
