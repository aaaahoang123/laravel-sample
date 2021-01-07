<?php


namespace HoangDo\Storage;

use Carbon\Carbon;
use Exception;
use HoangDo\Common\Exception\ExecuteException;
use HoangDo\Common\Helper\Constant;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Intervention\Image\ImageManagerStatic;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileStorageServiceImpl implements FileStorageService
{
    private $upload_path;
    private $acceptedMimes;
    private $dailyFolder;
    private array $compressibleExtension = ['jpg', 'jpeg', 'png'];

    public function __construct()
    {
        $this->upload_path = config('storage.path');
        $this->acceptedMimes = explode(',', config('storage.mimes'));
        $this->dailyFolder = explode(',', config('storage.daily_folder'));
    }

    /**
     * @inheritDoc
     */
    public function storeFile($file = null, $folder = '', $limit_width = 1000, $resolution = .8)
    {
        if (!$file)
            throw new BadRequestHttpException(__('messages.not_found_file'));
        try {
            $resource = ImageManagerStatic::make($file);
            $extension = str_replace('image/', '', $resource->mime());
            if (!Str::contains($extension, $this->acceptedMimes))
                throw new BadRequestHttpException(__('messages.invalid_file_type'));
            $folder = $this->resolveFolder($folder);
            $file_name = $this->generateName($extension);
            $path = $folder
                ? $folder . '/' . $file_name
                : $file_name;

            if (in_array($extension, $this->compressibleExtension)) {
                $this->compressResourceImage($resource, $path, $limit_width, $resolution);
            } else {
                $this->saveFile($resource, $path);
            }
            return $path;
        } catch (Exception $e) {
            if (!$file instanceof UploadedFile) {
                throw new RuntimeException('Not support save by string with non-image file.');
            }
            $extension = $file->extension();
            if (!Str::contains($extension, $this->acceptedMimes))
                throw new BadRequestHttpException(__('messages.invalid_file_type'));
            $file_name = $this->generateName($extension);
            $path = $folder
                ? $folder . '/' . $file_name
                : $file_name;
            $file->move(public_path($this->upload_path . $path));
            return $path;
        }
    }

    private function resolveFolder($folder = '') {
        if ($folder && in_array($folder, $this->dailyFolder))
            $folder .= '/' . Carbon::now()->format(Constant::FOLDER_LIKE_DATE_FORMAT);

        $folder = $folder ?? '';

        $folder_path = public_path($this->upload_path . $folder);
        if (!File::isDirectory($folder_path))
            File::makeDirectory($folder_path, 0755, true);

        return $folder;
    }

    /**
     * @inheritDoc
     */
    public function storeFiles($files = [], $folder = '', $limit_width = 1000, $resolution = .8)
    {
        $result = [];
        foreach ($files as $file)
            $result[] = $this->storeFile($file, $folder, $limit_width, $resolution);

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
    public function uploadedUrl($path = '')
    {
        return url($this->upload_path . $path);
    }

    public function fullPath($path = '')
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
     * @param float $quality
     */
    private function compressResourceImage($source_image, $path, $limit_width = 400, $quality = .8) {
        $width = $source_image->width();
        $height = $source_image->height();
        if ($width > $limit_width) {
            $source_image = $source_image
                ->resize($limit_width, $limit_width * $height / $width)
                ->encode('jpg', $quality * 100);
        }
        $this->saveFile($source_image, $path);
    }

    /**
     * @param Image $source_image
     * @param string $path
     */
    private function saveFile($source_image, $path)
    {
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
