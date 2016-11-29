<?php namespace Unisharp\Laravelfilemanager\controllers;

use Unisharp\Laravelfilemanager\controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Unisharp\Laravelfilemanager\httpclient\ImgDataHttpClient;

/**
 * Class ItemsController
 * @package Unisharp\Laravelfilemanager\controllers
 */
class ItemsController extends LfmController {


    /**
     * Get the images to load for a selected folder
     *
     * @return mixed
     */
    public function getItems()
    {
        $type = Input::get('type');
        $view = $this->getView($type);
        $path = parent::getPath();

        $files       = File::files($path);
        usort($files, function ($a, $b) {
            $a = filemtime($a);
            $b = filemtime($b);
            if ($a == $b) {
                return 0;
            }
            return ($a > $b) ? -1 : 1;
        });

        $current_page = Input::get('page', 1);
        $totalRecord = 0;
        $files = $this->filterByKeywordCategories($files, Input::get('keyword'), Input::get('cat_id'),
            Input::get('subcat_id'), $current_page, $totalRecord);
        $file_info   = $this->getFileInfos($files, $type);
        $directories = parent::getDirectories($path);
        $thumb_url   = parent::getUrl('thumb');

        $items_per_page = 30;
        $pages = ($items_per_page == 0) ? [1] : range(1, ceil($totalRecord / $items_per_page));

        return view($view)
            ->with(compact('files', 'file_info', 'directories', 'thumb_url', 'pages', 'current_page'));
    }


    private function getFileInfos($files, $type = 'Images')
    {
        $file_info = [];

        foreach ($files as $key => $file) {
            $file_name = parent::getFileName($file)['short'];

            if (!File::exists($file)) {
                $file_info[$key] = [
                    'name'      => $file_name,
                    'size'      => 'unknown',
                    'created'   => 'unknown',
                    'type'      => 'unknown',
                    'icon'      => 'fa-exclamation-triangle',
                    'folders'   => $this->getFormattedPath($file)
                ];
                continue;
            }

            $file_created = filemtime($file);
            $file_size = number_format((File::size($file) / 1024), 2, ".", "");

            if ($file_size > 1024) {
                $file_size = number_format(($file_size / 1024), 2, ".", "") . " Mb";
            } else {
                $file_size = $file_size . " Kb";
            }

            if ($type === 'Images') {
                $file_type = File::mimeType($file);
                $icon = '';
            } else {
                $extension = strtolower(File::extension($file_name));

                $icon_array = Config::get('lfm.file_icon_array');
                $type_array = Config::get('lfm.file_type_array');

                if (array_key_exists($extension, $icon_array)) {
                    $icon = $icon_array[$extension];
                    $file_type = $type_array[$extension];
                } else {
                    $icon = "fa-file";
                    $file_type = "File";
                }
            }

            $file_info[$key] = [
                'name'      => $file_name,
                'size'      => $file_size,
                'created'   => $file_created,
                'type'      => $file_type,
                'icon'      => $icon,
                'folders'   => $this->getFormattedPath($file)
            ];
        }

        return $file_info;
    }

    private function getFormattedPath($file)
    {
        $file_name = parent::getFileName($file)['short'];

        $shared_folder_name = config('lfm.shared_folder_name');
        $pos_share = strpos($file, $shared_folder_name);

        if ($pos_share !== false) {
            $path_start = $pos_share + strlen($shared_folder_name . '/');
        } else {
            $path_start = strpos($file, 'public/') + strlen('public/');
        }

        $folders = substr($file, $path_start, strlen($file) - strlen($file_name) - $path_start);

        $path_to_display = implode(' / ', explode('/', $folders));

        return $path_to_display ?: '根目錄 / ';
    }


    private function getView($type = 'Images')
    {
        $view = 'laravel-filemanager::images';

        if ($type !== 'Images') {
            $view = 'laravel-filemanager::files';
        }

        if (Input::get('keyword') !== "" || Input::get('cat_id') !== "" || Input::get('subcat_id') !== "") {
            $view = 'laravel-filemanager::search';
        }

        if (Input::get('show_list') == 1) {
            $view .= '-list';
        }

        return $view;
    }

    private function filterByKeywordCategories($origFiles, $keyword, $cat_id, $subcat_id, $page, &$totalRecord)
    {
        if ($keyword === "" && $cat_id === "" && $subcat_id === "") {
            return $origFiles;
        }

        $queryResult = ImgDataHttpClient::listFilenamesByKeywordCategories($keyword, $cat_id, $subcat_id, $page);
        $totalRecord = $queryResult->total;
        $foundNames = $queryResult->filenames;
        $files = [];
        foreach ($foundNames as $file) {
            $files[] = public_path(substr($file, 1));
        }
        return $files;
    }
}
