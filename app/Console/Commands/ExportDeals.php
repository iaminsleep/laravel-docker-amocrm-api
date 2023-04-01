<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use AmoCRM\Client\AmoCRMApiClient;
use App\Models\Deal;

class ExportDeals extends Command
{
    protected $signature = 'export:deals';

    protected $description = 'Export deals from amoCRM';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $apiClient = new AmoCRMApiClient(
            env('AMOCRM_DOMAIN'),
            env('AMOCRM_INTEGRATION_ID'),
            env('AMOCRM_CLIENT_SECRET'),
            env('AMOCRM_REDIRECT_URI')
        );

        $apiClient->setAccessToken(env('AMOCRM_ACCESS_TOKEN'));

        $leadsService = $apiClient->leads();

        $response = $leadsService->get();

        foreach ($response['_embedded']['items'] as $item) {
            $deal = new Deal();

            $deal->name = $item['name'];
            $deal->responsible_user_id = $item['responsible_user_id'];
            $deal->main_contact_id = $item['main_contact_id'];
            $deal->company_id = $item['company_id'];
            $deal->status_id = $item['price'];
            $deal->tags = $item['price'];

            $deal->save();
        }
    }
}
