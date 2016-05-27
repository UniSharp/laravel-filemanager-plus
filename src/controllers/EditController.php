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

        $entity = ImgDataHttpClient::getImgEntity($imgName);

        return View::make('laravel-filemanager::edit')
            ->with('imgsrc', parent::getUrl('directory') . 'thumbs/' . $imgName)
            ->with('imgName', $imgName)
            ->with('entity', $entity);
    }

    public function update($id) {
        $input = Input::get();
        foreach ($input as $key => $val) {
            if ($val === '') {
                $input[$key] = null;
            }
        }
        ImgDataHttpClient::updateImgEntity($id, $input);
    }

}
