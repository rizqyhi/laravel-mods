<?php

namespace Rizqyhi\LaravelMods\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class MakeModuleCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mods:create';

    protected $signature = 'mods:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a module set consists of routes, controllers, views, and language asset';

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $arguments = ['name' => trim($this->argument('name'))];
        
        $this->call('mods:controller', $arguments);
        $this->call('mods:views', $arguments);
        $this->call('mods:lang', $arguments);
    }
}
