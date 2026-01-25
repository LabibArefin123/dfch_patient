<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Exception;

class CheckOpenAIConnection extends Command
{
    protected $signature = 'openai:check'; // The command name
    protected $description = 'Check if OpenAI API is connected and responding.';

    public function handle()
    {
        $apiKey = config('services.openai.key'); // Ensure your OpenAI key is in config/services.php
        if (!$apiKey) {
            $this->error('❌ OpenAI API key is missing in config/services.php');
            return;
        }

        $client = new Client();
        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => 'Hello, are you connected?']
                    ],
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['choices'][0]['message']['content'])) {
                $this->info("✅ OpenAI is connected! Response: " . $result['choices'][0]['message']['content']);
            } else {
                $this->error('❌ OpenAI connection failed.');
            }
        } catch (Exception $e) {
            $this->error('❌ OpenAI API request failed: ' . $e->getMessage());
        }
    }
}
