<?php

namespace Rizqyhi\LaravelMods\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeViewsCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mods:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a set of views for module';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    protected $viewFiles = [
        'list', 'show', 'create', 'edit'
    ];

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/view.stub';
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

        foreach ($this->viewFiles as $file) {
            $path = $this->getViewFilePath($file);
            $this->makeDirectory($path);
            $this->files->put($path, $stub);
        }

        $this->info('Views created successfully.');
    }

    protected function getModuleName()
    {
        return Str::snake(Str::plural($this->getNameInput()));
    }

    protected function getViewFilePath($filename)
    {
        return base_path(sprintf(
            'resources/views/modules/%s/%s',
            $this->getModuleName(),
            $filename.'.blade.php'
        ));
    }
}
