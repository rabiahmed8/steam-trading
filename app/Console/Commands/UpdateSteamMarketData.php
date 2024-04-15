<?php

namespace App\Console\Commands;

use App\Models\SteamMarketItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateSteamMarketData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-steam-market-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $totalRecords = SteamMarketItem::count();
        $start = SteamMarketItem::count();
        $count = 100;
        $appId = 730;

        do {
            $response = Http::get("https://steamcommunity.com/market/search/render", [
                'norender' => 1,
                'start' => $start,
                'count' => $count,
                'appid' => $appId,
            ]);

            if ($response->status() === 429) {
                sleep(60);
                continue;
            }


            if (isset($response['results'])) {
                $items = $response['results'];

                foreach ($items as $item) {
                    $existingItem = SteamMarketItem::where('name', $item['name'])->first();
                    if (!$existingItem) {
                        SteamMarketItem::create([

                            'name' => $item['name'],
                            'game' => $item['app_name'],
                            'icon' => $item['asset_description']['icon_url'],
                            'icon_large' => $item['asset_description']['icon_url_large'],
                            'data' => json_encode($item),
                        ]);
                    }
                }


                $start += $count;
            } else {
                break;
            }
        } while (count($items) > 0);
    }
}
