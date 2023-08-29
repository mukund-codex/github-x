<?php

namespace App\Console\Commands;

use App\Models\GithubReleases;
use Http;
use Illuminate\Console\Command;

class FetchGithubReleases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:fetch-releases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches Github releases';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $dataToInsert = [];

        $token = env('GITHUB_PERSONAL_ACCESS_TOKEN');
        $api_url = env('GITHUB_API_URL');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ])->post($api_url, [
            'query' => (new GithubReleases)->graphqlQuery()
        ]);

        if ($response->json()) {
            $response_data = $response->json();
            foreach ($response_data['data']['repository']['releases']['edges'] as $data) {
                $dataToInsert = [...$dataToInsert, $data['node']];
            }
            GithubReleases::insert($dataToInsert);
            $this->info(trans('messages.github.releases.success'));
        }

        $this->error(trans('messages.github.releases.fail'));
    }
}
