<?php
namespace App\Service;

use App\Entity\Link;
use App\Repository\LinkRepository;

class FormatApiTwitter implements FormatApiDataInterface
{


    public function ApiCall(string $apiLink): void
    {
        // Implement the API call logic here
        // For example, you can use GuzzleHttp or cURL to make the request to the Twitter API
        // and then process the response using the format method.
        // Example of using GuzzleHttp:
        // $client = new \GuzzleHttp\Client();
        // $response = $client->request('GET', $apiLink, [
        //     'headers' => [
        //      
        $ch = curl_init($apiLink);
        $fp = fopen('response.json', 'w+');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            echo 'Success!';
        }
        
        curl_close($ch);
        fclose($fp);
    }

    public function format($data): array
    {
     

        // "data": [
        //     {
        //         "text": "lucina book https://t.co/d7cVubXSli",
        //         "id": "1908907475069538317",
        //         "edit_history_tweet_ids": [
        //             "1908907475069538317"
        //         ]
        //     }
        // ] JSON

        $testData = [
                    'text' => 'lucina book https://t.co/d7cVubXSli',
                    'id' => '1908907475069538317',
                    'edit_history_tweet_ids' => [
                        '1908907475069538317'
                    ]
                ];

        $jsonData = json_decode($testData, true);


        return $this->getData($jsonData);
    }

    public function getData(array $data): void {
        $formattedData = [];
        foreach ($data as $item) {
            
        }
        
    }
}