<?php

namespace App\Services\BallDontLieApi;

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

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getTeams()
    {
        try {

            $response = Http::withHeaders($this->headers)->get($this->baseUrl . '/teams');
            return $response->json();
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getGames(int $season)
    {
        $httpFilters = [
            'seasons' => $season
        ];

        try {

            $response = Http::withHeaders($this->headers)->get($this->baseUrl . '/games' . '?' . http_build_query($httpFilters));
            return $response->json();
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}