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

        $totalRecord = 0;// TODO: for pagination
        $files = $this->filterByKeywordCategories($files, Input::get('keyword'), Input::get('cat_id'),
            Input::get('subcat_id'), Input::get('page', 1), $totalRecord);
        $file_info   = $this->getFileInfos($files, $type);
        $directories = parent::getDirectories($path);
        $thumb_url   = parent::getUrl('thumb');

        $total_items_count = 200;
        $items_per_page = 30;
        $total_pages_count = ceil($total_items_count / $items_per_page);
        $current_page = Input::get('page', 1);
        $pages = range(1, $total_pages_count);
        $file_info = [];
        $files = [];

        $page_start = 0 + ($current_page - 1) * $items_per_page;
        $page_end = min($page_start + $items_per_page, $total_items_count);
        for ($i = $page_start; $i < $page_end; $i++) {
            $file = [];
            $file['name'] = 'test';
            $file['size'] = '50 kb';
            $file['type'] = 'image';
            $file['created'] = time();
            $files[$i] = 'test' . $i;
            $file_info[$i] = $file;
        }

        return view($view)
            ->with(compact('files', 'file_info', 'directories', 'thumb_url', 'pages', 'current_page'));
    }


    private function getFileInfos($files, $type = 'Images')
    {
        $file_info = [];

        foreach ($files as $key => $file) {
            $file_name = parent::getFileName($file)['short'];
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
            ];
        }

        return $file_info;
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
        foreach ($origFiles as $file) {
            if (in_array(parent::getFileName($file)['short'], $foundNames)) {
                $files[] = $file;
            }
        }
        return $files;
    }
}
