<?php
namespace App\Service;

use App\Service\FormatApiDataInterface;

class FormatApiDiscord implements FormatApiDataInterface
{
    public function ApiCall(string $apiLink): array {
        // Simulate an API call to Discord and return a sample response
         $data = [
            [
                'title' => 'Discord Message 1',
                'description' => 'This is a message from Discord.',
                'url' => 'https://discord.com/message/1',
                'created_at' => '2023-10-01T12:00:00Z',
            ],
            [
                'title' => 'Discord Message 2',
                'description' => 'Another message from Discord.',
                'url' => 'https://discord.com/message/2',
                'created_at' => '2023-10-02T12:00:00Z',
            ],
        ];

        return $this->format($data);
    }

    public function format(array $data): array
    {
        $formattedData = [];

        foreach ($data as $item) {
            $formattedData[] = [
                'title' => $item['title'] ?? 'No title',
                'description' => $item['description'] ?? 'No description',
                'url' => $item['url'] ?? 'No URL',
                'created_at' => $item['created_at'] ?? 'No date',
            ];
        }

        return $formattedData;
    }
}