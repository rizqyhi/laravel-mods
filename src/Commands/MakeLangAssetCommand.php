<?php

namespace Rizqyhi\LaravelMods\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeLangAssetCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mods:lang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a language asset file';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/lang.stub';
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $stub = $this->files->get($this->getStub());

        $this->makeDirectory($this->getLangFilePath());
        $this->files->put($this->getLangFilePath(), $stub);
        $this->info('Language file created successfully.');
    }

    protected function getLangFileName()
    {
        return Str::snake(Str::plural($this->getNameInput())).'.php';
    }

    protected function getLangFilePath()
    {
        return base_path('resources/lang/en/'.$this->getLangFileName());
    }
}
