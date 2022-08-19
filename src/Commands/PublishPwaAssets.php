<?php

namespace Ldtalent\Pwa\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Console\Command;

class PublishPwaAssets extends Command
{
	
	/**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'pwa-laravel:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Service Worker|Offline HTMl|manifest file for PWA application.';

    public $composer;
	
    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->composer = app()['composer'];
    }
	
    public function handle()
    {
        $publicDir = public_path();
        
        $manifestTemplate = file_get_contents(__DIR__.'/../Stubs/manifest.stub');
        $this->createFile($publicDir. DIRECTORY_SEPARATOR, 'manifest.json', $manifestTemplate);
        $this->info('manifest.json file is published.');
        
        $offlineHtmlTemplate = file_get_contents(__DIR__.'/../Stubs/offline.stub');
        $this->createFile($publicDir. DIRECTORY_SEPARATOR, 'offline.html', $offlineHtmlTemplate);
        $this->info('offline.html file is published.');     
        
        $swTemplate = file_get_contents(__DIR__.'/../Stubs/sw.stub');
        $this->createFile($publicDir. DIRECTORY_SEPARATOR, 'sw.js', $swTemplate);
        $this->info('sw.js (Service Worker) file is published.');     

        $this->info('Generating autoload files');
        $this->composer->dumpOptimized();

        $this->info('Greeting!.. Enjoy your pwa laravel app...');
    }

    public static function createFile($path, $fileName, $contents)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $path = $path.$fileName;

        file_put_contents($path, $contents);
    }

}