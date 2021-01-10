<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CompanyController extends Controller
{

    public function getCompanyByInn(Request $request)
    {

        $app_url = env("APP_URL");
        $inn = $request->get('inn', false);

        if (!$inn) {
            return response()->json(['status' => false], 404);
        }

        $client = new Client(
            [
                'timeout' => 2.0
            ]
        );

        $data_urls = [
            1 => $app_url . '/api/services/first/' . $inn,
            2 => $app_url . '/api/services/second/' . $inn,
            3 => $app_url . '/api/services/third/' . $inn,
        ];


        $data = ['status' => false];
        foreach ($data_urls as $url) {
            try {
                $response = $client->get($url);
                if ($response->getStatusCode() == 200) {
                    $data_response = $response->getBody()->getContents();
                    $res = json_decode($data_response, true);
                    if (isset($res['status']) && $res['status'] === true) {
                        $data = $res;
                        break;
                    }
                }
            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                logs()->info("Error Message : " . $e->getMessage() . "; Error Code : " . $e->getCode());
            }
        }


        return response()->json($data, 200);
    }

}
