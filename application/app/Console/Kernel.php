<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DOMDocument;
use App\Models\ContentInfo;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule
            ->call(function () {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://en.wikipedia.org/wiki/2023_Israel%E2%80%93Hamas_war',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                    'Cookie: GeoIP=US:DE:Hockessin:39.78:-75.69:v4; WMF-Last-Access-Global=06-Dec-2023; NetworkProbeLimit=0.001; WMF-DP=16d; WMF-Last-Access=06-Dec-2023'
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                libxml_use_internal_errors(true);

                $dom = new DOMDocument;
                $dom->loadHTML($response);
                libxml_use_internal_errors(false);

                // Find the element with id "cite_ref-26"
                $citeRef26 = $dom->getElementById('cite_ref-26');

                // Find the parent <ul> element
                if ($citeRef26) {
                    $parentUl = $citeRef26->parentNode->parentNode;

                    $text = $parentUl->nodeValue;

                    $info = [
                        'killed' => null,
                        'wounded' => null,
                        'missing' => null,
                    ];

                    // Use regular expressions to extract numbers from the text
                    preg_match('/(\d+,?\d+)\s*\+\s*killed/i', $text, $matches);
                    if (count($matches) === 2) {
                        $info['killed'] = str_replace(',', '', $matches[1]);
                    }

                    preg_match('/(\d+,?\d+)\s*\+\s*wounded/i', $text, $matches);
                    if (count($matches) === 2) {
                        $info['wounded'] = str_replace(',', '', $matches[1]);
                    }

                    preg_match('/(\d+,?\d+)\s*\+\s*missing/i', $text, $matches);
                    if (count($matches) === 2) {
                        $info['missing'] = str_replace(',', '', $matches[1]);
                    }

                }

                ContentInfo::create($info);
            })
            ->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
