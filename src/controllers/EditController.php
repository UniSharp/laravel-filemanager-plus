<?php namespace Unisharp\Laravelfilemanager\controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Unisharp\Laravelfilemanager\httpclient\ImgDataHttpClient;

/**
 * Class EditController
 * @package Unisharp\Laravelfilemanager\controllers
 */
class EditController extends LfmController {

    public function getEdit() {
        $imgName = Input::get('imgName');

        $data = ImgDataHttpClient::getImgEntity($imgName);
        $data_arr = json_decode(json_encode($data), true);

        $oriImgSrc = parent::getUrl('directory') . $imgName;
        $from = '/' . preg_quote(Config::get('lfm.images_url'), '/') . '/';
        $thumbImgSrc = preg_replace($from, Config::get('lfm.images_thumb_url'), $oriImgSrc, 1);
        return View::make('laravel-filemanager::edit')
            ->with('imgsrc', $thumbImgSrc)
            ->with('imgName', $imgName)
            ->with('entity', $data->image_entity)
            ->with('sourcemap', $data_arr['news_source'])
            ->with('category', $data_arr['category'])
            ->with('subcat', $data_arr['subcategory']);
    }

    public function update($id) {
        $input = Input::get();
        foreach ($input as $key => $val) {
            if ($val === '') {
                $input[$key] = null;
            }
        }
        $input['filepath'] = parent::getUrl();
        unset($input['working_dir']);
        ImgDataHttpClient::updateImgEntity($id, $input);
    }

}
