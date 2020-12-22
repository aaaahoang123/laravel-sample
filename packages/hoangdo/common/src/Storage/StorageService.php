<?php

namespace HoangDo\Common\Storage;

use HoangDo\Common\Exception\ExecuteException;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\UploadedFile;

interface StorageService
{
    /**
     * @param UploadedFile $file
     * @param string $folder
     * @return string
     * @throws ExecuteException
     */
    public function storeFile($file = null, $folder = '');

    /**
     * @param string $url
     * @param string $folder
     * @return string
     * @throws ExecuteException
     */
    function storeFileFromUrl($url, $folder = '');

    /**
     * @param UploadedFile[] $files
     * @param string $folder
     * @return string[]
     * @throws ExecuteException
     */
    public function storeFiles($files = [], $folder = '');

    /**
     * @param $path
     * @return bool
     */
    public function removeFile($path);

    /**
     * @param string[] $paths
     * @return void
     */
    function removeFiles($paths);
    /**
     * @param $old_path
     * @param UploadedFile $new_file
     * @param string $folder
     * @throws ExecuteException
     * @return string
     */
    public function replaceFile($old_path, UploadedFile $new_file, $folder = '');
    /**
     * @param $path
     * @return UrlGenerator|string
     */
    public function uploaded_url($path = '');

    /**
     * @param string $path
     * @return string
     */
    public function full_path($path = '');

    /**
     * @param string $path
     * @param int $new_width
     * @return string
     */
    public function compressImageKeepRatio($path, $new_width = 400);

    /**
     * @param string $path
     * @param int $new_width
     * @return string
     */
    function compressImageKeepRatioAndRemoveSource($path, $new_width = 400);

    function compressImageKeepRatioAndReplaceOld($path, $old_resource, $new_width = 400);
}
