<?php

namespace App\Services\BallDontLieApi;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class BallDontLieService
{
    protected string $baseUrl;

    protected string $apiKey;

    protected array $headers;

    public function __construct()
    {
        $this->baseUrl = config('ball-dont-lie.base_url');
        $this->apiKey = config('ball-dont-lie.api_key');
        $this->headers = [
            'Authorization' => $this->apiKey
        ];
    }

    public function getPlayers(int $cursor = 0, int $perPage = 25)
    {
        try {

            $httpFilters = [
                'cursor' => $cursor,
                'per_page' => $perPage
            ];

            $response = Http::withHeaders($this->headers)->get($this->baseUrl . '/players' . '?' . http_build_query($httpFilters));
            return $this->handleResponse($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getTeams()
    {
        try {

            $response = Http::withHeaders($this->headers)->get($this->baseUrl . '/teams');
            return $this->handleResponse($response);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getGames(array $seasons, int $cursor = 0, int $perPage = 25)
    {
        $httpFilters = [
            'seasons' => $seasons,
            'cursor' => $cursor,
            'per_page' => $perPage
        ];

        try {

            $response = Http::withHeaders($this->headers)->get($this->baseUrl . '/games' . '?' . http_build_query($httpFilters));
            return $this->handleResponse($response);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function handleResponse(Response|PromiseInterface $response): array
    {
        if ($response->ok()) {
            return $response->json();
        }

        if ($response->status() === 429) {
            return [
                'error' => [
                    'message' => 'Rate limit exceeded',
                    'code' => $response->status()
                ]
            ];
        }

        return [
            'error' => [
                'message' => 'Something went wrong',
                'code' => $response->status()
            ]
        ];
    }
}