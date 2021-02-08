<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller {

    public function getCompanyByInn(Request $request) {
        $inn = $request->get('inn', false);

        if (!$inn) {
            return response()->json(['status' => false], 404);
        }

        self::http($inn)
                ->then(function ($response) {
                    echo $response;
                })
                ->otherwise(function (\Exception $exception) {
                    echo $exception->getMessage();
                });
    }

    public static function http($inn) {

        $deferred = new \React\Promise\Deferred();
        $loop = \React\EventLoop\Factory::create();

        $client = new \React\Http\Browser($loop);


        $app_url = env("APP_URL");

        $request = [
            $app_url . '/api/services/first/' . $inn,
            $app_url . '/api/services/second/' . $inn,
            $app_url . '/api/services/third/' . $inn,
        ];


        $promises = [];
        foreach ($request as $url) {
            $promises[] = $client->withTimeout(1.0)->get($url);
        }


        \React\Promise\any($promises)
                ->then(function (\Psr\Http\Message\ResponseInterface $response) use ($promises) {
                    foreach ($promises as $promise) {
                        $promise->cancel();
                    }
                    echo $response->getBody();
                }
                )
                ->otherwise(function (\React\Promise\Exception\CompositeException $error) {

                    foreach ($error->getThrowables() as $err_msh) {
                        echo $err_msh->getMessage() . PHP_EOL;
                    }
                })
        ;

        $loop->run();

        return $deferred->promise();
    }

}
