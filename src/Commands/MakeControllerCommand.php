<?php

namespace Rizqyhi\LaravelMods\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeControllerCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mods:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a set of action controllers and their routes';

    /**
     * Indicates whether the command should be shown in the Artisan command list.
     *
     * @var bool
     */
    protected $hidden = true;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * The routes stub content
     *
     * @var string
     */
    protected $routesStub;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/controller.stub';
    }

    protected function loadRoutesStub()
    {
        $this->routesStub = $this->files->get(__DIR__.'/../stubs/routes.stub');
    }

    protected function getActions()
    {
        return ['list', 'show', 'create', 'store', 'edit', 'update', 'delete'];
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->loadRoutesStub();

        foreach ($this->getActions() as $action) {
            $className = $this->qualifyClass($this->generateClassNameFor($action));
            $path = $this->getPath($className);

            if ((! $this->hasOption('force') ||
                 ! $this->option('force')) &&
                 $this->files->exists($path)) {
                $this->error($className.' already exists!');
                continue;
            }
            
            $this->buildRouteFor($action);
            $this->makeDirectory($path);
            $this->files->put($path, $this->buildClass($className));
        }
        
        $this->info('Controllers created successfully.');
        $this->appendRoutes();
    }

    /**
     * Build route per action controller
     *
     * @param string $action
     * @param string $className
     * @return void
     */
    protected function buildRouteFor($action)
    {
        $pluralName = Str::plural($this->getNameInput());
        $className = sprintf('%s\%s', Str::studly($pluralName), $this->generateClassNameFor($action));

        $this->routesStub = str_replace(
            ['dummyroutes', "[$action]", 'dummyRouteName'],
            [Str::snake($pluralName), $className, Str::snake($pluralName)],
            $this->routesStub
        );
    }

    /**
     * Generate class name based on action and name
     *
     * @param string $action
     * @return void
     */
    protected function generateClassNameFor($action)
    {
        return implode('', [
            ucfirst($action),
            $this->getNameInput(),
            'Controller'
        ]);
    }

    /**
     * Appends the generated routes into default app's route file
     *
     * @return void
     */
    protected function appendRoutes()
    {
        $this->files->append(base_path('routes/web.php'), "\n".$this->routesStub."\n");
        $this->info('Routes appended successfully.');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = Str::plural($this->getNameInput());

        return sprintf('%s\Http\Controllers\%s', $rootNamespace, $namespace);
    }
}
