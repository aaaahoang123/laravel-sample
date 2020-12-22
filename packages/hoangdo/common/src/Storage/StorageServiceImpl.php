<?php


namespace HoangDo\Common\Storage;

use Carbon\Carbon;
use HoangDo\Common\Exception\ExecuteException;
use HoangDo\Common\Helper\Constant;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;

class StorageServiceImpl implements StorageService
{
    private $upload_path;

    public function __construct()
    {
        $this->upload_path = config('storage.path');
    }

    /**
     * @param UploadedFile|string $file
     * @param string $folder
     * @return string
     * @throws ExecuteException
     */
    public function storeFile($file = null, $folder = '')
    {
        if (!$file)
            throw new ExecuteException(__('messages.not_found_file'));
        $resource = ImageManagerStatic::make($file);
        $extension = str_replace('image/', '', $resource->mime());
        if (!Str::contains($extension, config('storage.mimes')))
            throw new ExecuteException(__('messages.invalid_file_type'));
        $folder = $this->resolveFolder($folder);
        $file_name = $this->generateName();
        $path = $folder
            ? $folder . '/' . $file_name
            : $file_name;

        $this->compressResourceImage($resource, $path, 1000);
        return $path;
    }

    public function storeFileFromUrl($url, $folder = '')
    {
        return $this->storeFile($url, $folder);
    }

    private function resolveFolder($folder = '') {
        if ($folder && in_array($folder, config('storage.daily_folder')))
            $folder .= '/' . Carbon::now()->format(Constant::FOLDER_LIKE_DATE_FORMAT);

        $folder = $folder ?? '';

        $folder_path = public_path($this->upload_path . $folder);
        if (!File::isDirectory($folder_path))
            File::makeDirectory($folder_path, 0755, true);

        return $folder;
    }

    /**
     * @param UploadedFile[] $files
     * @param string $folder
     * @return string[]
     * @throws ExecuteException
     */
    public function storeFiles($files = [], $folder = '')
    {
        $result = [];
        foreach ($files as $file)
            $result[] = $this->storeFile($file, $folder);

        return $result;
    }

    /**
     * @param $path
     * @return bool
     */
    public function removeFile($path)
    {
        $true_path = public_path($this->upload_path . $path);
        return File::delete($true_path);
    }

    public function removeFiles($paths)
    {
        foreach ($paths as $path)
            $this->removeFile($path);
    }

    /**
     * @param $old_path
     * @param UploadedFile $new_file
     * @param string $folder
     * @throws ExecuteException
     * @return string
     */
    public function replaceFile($old_path, UploadedFile $new_file, $folder = '')
    {
        $this->removeFile($old_path);
        return $this->storeFile($new_file, $folder);
    }

    /**
     * @param $path
     * @return UrlGenerator|string
     */
    public function uploaded_url($path = '')
    {
        return url($this->upload_path . $path);
    }

    public function full_path($path = '')
    {
        return '/' . $this->upload_path . $path;
    }

    public function compressImageKeepRatio($path, $new_width = 400)
    {
        $new_path = $this->generatePathFromOldPath($path);
        $source_image = ImageManagerStatic::make(public_path($this->upload_path . $path));
        $this->compressResourceImage($source_image, $new_path, $new_width);
        return $new_path;
    }

    /**
     * Lưu file ảnh lại, trong trường hợp ảnh lớn hơn giới hạn cho phép thì resize lại theo giới hạn
     *
     * @param Image $source_image
     * @param $path
     * @param int $limit_width
     */
    private function compressResourceImage($source_image, $path, $limit_width = 400) {
        $width = $source_image->width();
        $height = $source_image->height();
        if ($width > $limit_width) {
            $source_image = $source_image
                ->resize($limit_width, $limit_width * $height / $width)
                ->encode('jpg', 80);
        }
        $source_image->save(public_path($this->upload_path . $path));
    }

    public function compressImageKeepRatioAndRemoveSource($path, $new_width = 400)
    {
        $new_image = $this->compressImageKeepRatio($path, $new_width);
        $this->removeFile($path);
        return $new_image;
    }

    public function compressImageKeepRatioAndReplaceOld($path, $old_resource, $new_width = 400)
    {
        $new_image = $this->compressImageKeepRatio($path, $new_width);
        $this->removeFile($old_resource);
        return $new_image;
    }

    private function generateName($extension = 'jpg') {
        return Str::random(10) . '-' . round(microtime(true)) . '.' . $extension;
    }

    private function generatePathFromOldPath($old_path, $new_extension = 'jpg') {
        $path_extract = explode('/', $old_path);
        $path_extract[count($path_extract) - 1] = $this->generateName($new_extension);
        return implode('/', $path_extract);
    }
}
