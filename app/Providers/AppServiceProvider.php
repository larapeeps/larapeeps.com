<?php

declare(strict_types=1);

namespace App\Providers;

use ActivityPhp\Server;
use ActivityPhp\Type\Dialect;
use ActivityPhp\Type\TypeConfiguration;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->singleton(Server::class, function(Application $app) {
			$path = $app->storagePath('app/activitypub');
			$app->make(Filesystem::class)->ensureDirectoryExists($path);
			
			$server = new Server([
				'ontologies' => ['*'],
				'cache' => [
					'stream' => $path,
				],
			]);
			
			TypeConfiguration::set('undefined_properties', 'include');
			
			return $server;
		});
	}
	
	public function boot(): void
	{
		Model::unguard();
		
		seo()->twitterImage(asset('img/twitter-card.png?v=2.0'));
	}
}
