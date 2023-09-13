<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerRequest;
use App\Models\Banner;
use App\Services\FileUploadService;
use Illuminate\Http\Response;

class BannerController extends Controller
{
    public function __construct(private readonly FileUploadService $fileUploadService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response([
            'banners' => Banner::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request): Response
    {
        $data = $request->validated();
        $data['image'] = $this->fileUploadService->fileUpload($data['image'], 'banners/images')['path'];

        $banner = Banner::create($data);

        return response([
            'banner' => $banner
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner): Response
    {
        return response([
            'banner' => $banner
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, Banner $banner): Response
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = $this->fileUploadService->fileUpload($data['image'], 'banners/images')['path'];
            $this->fileUploadService->deleteFile($banner->image);
        }

        $banner->update($data);

        return response([
            'banner' => $banner->refresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner): Response
    {
        $banner->delete();

        return response([
            'message' => 'banner deleted'
        ]);
    }
}
