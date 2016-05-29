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
        $response = $client->request('GET', self::getApiUriPrefix() . '/get_by_filename/' . $filename);
        $resObj = json_decode($response->getBody());
        
        $entity = [];
        if ($resObj->status->code === 200) {
            $entity = $resObj->data;
        }
        return $entity;
    }

    public static function deteleImgEntity($filename) {
        $client = new Client();
        $response = $client->request('DELETE', self::getApiUriPrefix() . '/delete_by_filename/' . $filename);
    }

    public static function updateImgEntity($id, $data) {
        $client = new Client();
        $response = $client->request('POST', self::getApiUriPrefix() . '/update/' . $id, ['form_params'=>$data]);
        if ($response->getStatusCode() === 200) {
            echo 'OK';
        }
    }

    public static function  listFilenamesByKeyword($keyword) {
        return ['574877861aa70.png', '574b18099d92a.png'];
    }

    private static function getApiUriPrefix() {
        return self::getHost() . self::$api_prefix;
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
