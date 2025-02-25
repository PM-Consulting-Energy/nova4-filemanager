<?php

namespace Stepanenko3\NovaFilemanager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Stepanenko3\NovaFilemanager\Services\FileManagerService;
use Laravel\Nova\Http\Requests\NovaRequest;

class FilemanagerToolController extends Controller
{
    /**
     * @var mixed
     */
    protected FileManagerService $service;

    /**
     * @param FileManagerService $filemanagerService
     */
    public function __construct(FileManagerService $filemanagerService)
    {
        $this->service = $filemanagerService;
    }

    /**
     * @param Request $request
     */
    public function getData(Request $request)
    {
        return $this->service->ajaxGetFilesAndFolders($request);
    }

    /**
     * @param Request $request
     */
    public function getDataField($resource, $attribute, NovaRequest $request)
    {
        return $this->service->ajaxGetFilesAndFolders($request);
    }

    /**
     * @param Request $request
     */
    public function createFolder(Request $request)
    {
        return $this->service->createFolderOnPath($request->folder, $request->current);
    }

    /**
     * @param Request $request
     */
    public function deleteFolder(Request $request)
    {
        return $this->service->deleteDirectory($request->current);
    }

    /**
     * @param Request $request
     */
    public function upload(Request $request)
    {
        $uploadingFolder = $request->folder ?? false;

        return $this->service->uploadFile(
            $request->file,
            $request->current ?? '',
            $request->visibility,
            $uploadingFolder,
            $request->rules ? $this->getRules($request->rules) : []
        );
    }

    /**
     * @param Request $request
     */
    public function move(Request $request)
    {
        return $this->service->moveFile($request->old, $request->path);
    }

    /**
     * @param Request $request
     */
    public function getInfo(Request $request)
    {
        return $this->service->getFileInfo($request->file);
    }

    /**
     * @param Request $request
     */
    public function removeFile(Request $request)
    {
        return $this->service->removeFile($request->file, $request->type);
    }

    /**
     * @param Request $request
     */
    public function downloadFile(Request $request)
    {
        return $this->service->downloadFile($request->file);
    }

    /**
     * @param Request $request
     */
    public function duplicate(Request $request)
    {
        return $this->service->duplicateFile($request->path);
    }

    /**
     * @param Request $request
     */
    public function rename(Request $request)
    {
        return $this->service->renameFile($request->path, $request->name);
    }

    /**
     * @param Request $request
     */
    public function folderUploadedEvent(Request $request)
    {
        return $this->service->folderUploadedEvent($request->path);
    }

    /**
     * @param Request $request
     */
    public function inertiaMainRoute(Request $request)
    {
        return inertia('NovaFilemanager');
    }

    /**
     * Get rules in array way.
     *
     * @param   string  $rules
     *
     * @return  array
     */
    private function getRules($rules)
    {
        return json_decode($rules);
    }
}
