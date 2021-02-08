<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class ServiceController extends Controller
{

    public function getFirstCompanyInfo(string $inn)
    {
        $client = new Client(
            [
                'timeout' => 1.0
            ]
        );

        $url = 'https://htmlweb.ru/json/service/org?inn=' . $inn;
        $data = ['status' => false];

        try {
            $response = $client->get($url);
            if ($response->getStatusCode() == 200) {
                $data_response = $response->getBody()->getContents();
                $result = json_decode($data_response, true);
                if (isset($result['status']) && $result['status'] === 'ACTIVE') {
                    $data = [
                        'Inn'    => $inn,
                        'status' => true,
                        'info'   => [
                            'company_name'    => $result['name'],
                            'company_kpp'     => 'company_kpp_' . Str::random(5),
                            'company_address' => $result['address'],
                            'company_inn'     => $inn
                        ],
                        'method' => __FUNCTION__
                    ];
                }
            }
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            logs()->info("Error Message : " . $e->getMessage() . "; Error Code : " . $e->getCode());
        }

        return response()->json($data, 200);
    }

    //Заглушка
    public function getSecondCompanyInfo(string $inn)
    {
        sleep(rand(1, 3));

        $data = [
            'Inn'    => $inn,
            'status' => true,
            'info'   => [
                'company_name'    => 'company_name_' . Str::random(5),
                'company_kpp'     => 'company_kpp_' . Str::random(5),
                'company_address' => 'company_address_' . Str::random(5),
                'company_inn'     => $inn
            ],
            'method' => __FUNCTION__
        ];


        return response()->json($data, 200);
    }

    //Заглушка
    public function getThirdCompanyInfo(string $inn)
    {
        sleep(rand(1, 3));

        $data = [
            'Inn'    => $inn,
            'status' => true,
            'info'   => [
                'company_name'    => 'company_name_' . Str::random(5),
                'company_kpp'     => 'company_kpp_' . Str::random(5),
                'company_address' => 'company_address_' . Str::random(5),
                'company_inn'     => $inn
            ],
            'method' => __FUNCTION__
        ];


        return response()->json($data, 200);
    }

}
