<?php

namespace Unisharp\Laravelfilemanager\httpclient;

use GuzzleHttp\Client;

class ImgDataHttpClient {

    private static $api_prefix = '/api/v1/news_images';

    public function __construct()
    {
    }

    public static function getImgEntity($filename) {
        $client = new Client();
        $response = $client->get(self::getHost() . self::$api_prefix . '/get_by_filename/' . $filename);
        $resJson = $response->json();
        
        $entity = [];
        if ($resJson['status']['code'] === 200) {
            $entity = $resJson['data'];
        }
        return $entity;
    }

    public static function deteleImgEntity($filename) {
        $client = new Client();
        $response = $client->delete(self::getHost() . self::$api_prefix . '/delete_by_filename/' . $filename);
        $resJson = $response->json();
    }

    private static function getHost() {
        $host = "";
        $extEnable = config('lfm.ext_enable');
        if ($extEnable) {
            $host = config('lfm.ext_host');
            //TODO for test inside homestead
            $host = explode(':8000', $host)[0];
        }
        return $host;
    }
}
