<?php namespace Unisharp\Laravelfilemanager\controllers;

use Unisharp\Laravelfilemanager\controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Lang;
use Unisharp\Laravelfilemanager\httpclient\ImgDataHttpClient;

/**
 * Class CropController
 * @package Unisharp\Laravelfilemanager\controllers
 */
class DeleteController extends LfmController {

    /**
     * Delete image and associated thumbnail
     *
     * @return mixed
     */
    public function getDelete()
    {
        $longFileName = Input::get('items');
        $name_to_delete = pathinfo($longFileName)['basename'];

        $file_path = parent::getPath('directory');

        $file_to_delete = public_path(). Config::get('lfm.images_url') . $longFileName;
        $thumb_to_delete = public_path(). Config::get('lfm.images_thumb_url') . $longFileName;

        if (!File::exists($file_to_delete)) {
            return $file_to_delete . ' not found!';
        }

        if (File::isDirectory($file_to_delete)) {
            if (sizeof(File::files($file_to_delete)) != 0) {
                return Lang::get('laravel-filemanager::lfm.error-delete');
            }

            File::deleteDirectory($file_to_delete);

            return 'OK';
        }

        File::delete($file_to_delete);

        if ('Images' === $this->file_type) {
            File::delete($thumb_to_delete);
        }

        // delete image record
        ImgDataHttpClient::deteleImgEntity($name_to_delete);

        return 'OK';
    }

}
