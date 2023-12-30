<?php

namespace App\Providers;

use App\Models\User;

use Illuminate\Support\ServiceProvider;
use Spatie\Prometheus\Collectors\Horizon\CurrentMasterSupervisorCollector;
use Spatie\Prometheus\Collectors\Horizon\CurrentProcessesPerQueueCollector;
use Spatie\Prometheus\Collectors\Horizon\CurrentWorkloadCollector;
use Spatie\Prometheus\Collectors\Horizon\FailedJobsPerHourCollector;
use Spatie\Prometheus\Collectors\Horizon\HorizonStatusCollector;
use Spatie\Prometheus\Collectors\Horizon\JobsPerMinuteCollector;
use Spatie\Prometheus\Collectors\Horizon\RecentJobsCollector;
use Spatie\Prometheus\Facades\Prometheus;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PrometheusServiceProvider extends ServiceProvider
{
    public function register()
    {
        /*
         * Here you can register all the exporters that you
         * want to export to prometheus
         */
        Prometheus::addGauge('My gauge')
            ->value(function() {
                return 123.45;
            });

        Prometheus::addGauge('user_count', function () {
                return User::count();
            });  
            
            Prometheus::addGauge('broken_links', function () {
                $links = ['https://www.google.com', 'https://www.facebook.com.xxxx', 'https://www.linkedin.com', 'https://www.twitter.com', 'https://www.youtube.com', 'https://www.instagram.com', 'https://www.pinterest.com', 'https://www.tumblr.com', 'https://www.reddit.com', 'https://www.snapchat.com', 'https://www.whatsapp.com', 'https://www.messenger.com', 'https://www.quora.com', 'https://www.vimeo.com', 'https://www.flickr.com', 'https://www.piringundin.com'];
                $client = new Client();
            
                $brokenLinks = 0;
            
                foreach ($links as $link) {
                    try {
                        $response = $client->get($link);
                    } catch (\GuzzleHttp\Exception\ConnectException $e) {
                        // Manejar la excepción en caso de un error de conexión
                        $brokenLinks++;
                        Log::error('Connection error for link: ' . $link);
                    } catch (\GuzzleHttp\Exception\RequestException $e) {
                        // Si se produce una excepción, consideramos el enlace como roto
                        $brokenLinks++;
                        // Puedes loguear el error si es necesario
                        Log::error('Broken link: ' . $link);
                    }
                }
            
                // Devolver la cantidad de enlaces rotos
                return $brokenLinks;
            });
            
            
            
            

        /*
         * Uncomment this line if you want to export
         * all Horizon metrics to prometheus
         */
        //$this->registerHorizonCollectors();
    }

    public function registerHorizonCollectors(): self
    {
        Prometheus::registerCollectorClasses([
            CurrentMasterSupervisorCollector::class,
            CurrentProcessesPerQueueCollector::class,
            CurrentWorkloadCollector::class,
            FailedJobsPerHourCollector::class,
            HorizonStatusCollector::class,
            JobsPerMinuteCollector::class,
            RecentJobsCollector::class,
        ]);

        return $this;
    }
}
