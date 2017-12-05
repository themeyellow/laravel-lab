<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeNewPackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:new {name} {--dir=../packages/}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new package and adds it to this lab.';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $packagePath = base_path().'/'.$this->option('dir').'/'.$this->argument('name');

        if ($this->files->isDirectory($packagePath)) {
            return $this->error('The package already exists!');
        }

        $this->files->makeDirectory($packagePath);

        $this->call('package:add', [
            'name' => $this->argument('name'),
            'path' => $this->option('dir').'/'.$this->argument('name')
        ]);
    }
}