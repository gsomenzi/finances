<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ExchangeRate;
use \Carbon\Carbon;

class UpdateExchangeRates extends Command
{
    protected $baseUrl = 'https://api.currencyapi.com/v3';
    protected $apiKey = 'xhg77yeuVRNg1Rjq8NxGDpWbpw7vPVYFeDIMOU70';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange-rates:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca via API valores atualizados sobre cotacao de moedas, relacionadas ao BRL';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::withHeaders([
            'apikey' => $this->apiKey
        ])->get($this->baseUrl.'/latest?base_currency=BRL');

        $jsonResponse = $response->json();
        if (isset($jsonResponse['meta']) && $jsonResponse['data']) {
            $last_updated_at = Carbon::parse($jsonResponse['meta']['last_updated_at']);
            foreach ($jsonResponse['data'] as $exchangeData) {
                ExchangeRate::updateOrCreate(
                    ['code' => $exchangeData['code']],
                    ['value' => $exchangeData['value'], 'last_updated_at' => $last_updated_at->format('Y-m-d H:i:s')]
                );
            }
            $this->info('Dados de conversão atualizados com sucesso.');
            return Command::SUCCESS;
        } else {
            $this->error('Dados de conversão não retornados pela API.');
            return Command::FAILURE;
        }
    }
}
