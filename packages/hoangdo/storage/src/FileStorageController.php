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
        $path = $this->fileStorageService->storeFile($file, $folder);

        return [
            'path' => $path,
            'url' => $this->fileStorageService->uploadedUrl($path),
            'full_path' => $this->fileStorageService->fullPath($path)
        ];
    }
}
