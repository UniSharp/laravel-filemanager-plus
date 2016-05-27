<?php

namespace Unisharp\Laravelfilemanager\httpclient;

use GuzzleHttp\Client;

class ImgDataHttpClient {

    public function __construct()
    {
    }

    public static function getImgEntity($filename) {
        $client = new Client();
        $response = $client->get(self::getHost() . '/news_images/get_by_filename/' . $filename);
        $resJson = $response->json();
        
        $entity = [];
        if ($resJson['status']['code'] === 200) {
            $entity = $resJson['data'];
        }
        return $entity;
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
