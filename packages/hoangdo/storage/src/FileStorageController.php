<?php


namespace HoangDo\Storage;


use Illuminate\Routing\Controller;

class FileStorageController extends Controller
{
    private FileStorageService $fileStorageService;

    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    public function upload(StorageRequest $req): array
    {
        $file = $req->file('file') ?? $req->get('file');
        $folder = $req->get('folder');
        $max_width = $req->get('max_width') ?? 1000;
        if ($max_width > 2000) $max_width = 2000;
        $max_width = min($max_width, 2000);
        $resolution = $req->get('resolution') ?? .8;
        if ($resolution > 1) $resolution = 1;
        $resolution = min($resolution, 1);
        $path = $this->fileStorageService->storeFile($file, $folder, $max_width, $resolution);

        return [
            'path' => $path,
            'url' => $this->fileStorageService->uploadedUrl($path),
            'full_path' => $this->fileStorageService->fullPath($path)
        ];
    }
}
