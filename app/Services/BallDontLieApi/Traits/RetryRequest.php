<?php

namespace App\Services\BallDontLieApi\Traits;

trait RetryRequest {
    
    protected function retryRequest(callable $callback, int $tries = 3, int $delaySeconds = 60)
    {
        $attempt = 0;

        beginning:

        try {
            $response = $callback();

            if (isset($response['error']) && $response['error']['code'] === 429) {
                throw new \RuntimeException('Rate limit');
            }

            return $response;

        } catch (\Throwable $e) {

            $attempt++;

            if ($attempt >= $tries) {
                $this->error('Falha após múltiplas tentativas.');
                throw $e;
            }

            $this->warn("Rate limit atingido. Tentando novamente em {$delaySeconds}s...");
            sleep($delaySeconds);

            goto beginning;
        }
    }
}