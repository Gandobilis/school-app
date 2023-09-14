<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\Response;
use App\Services\FileUploadService;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $banners = Banner::all();

        if ($banners->isEmpty()) {
            return response(['message' => 'No banners found'], 404);
        }

        return response(['banners' => $banners]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request): Response
    {
        $data = $request->validated();
        $data['image'] = fileUploadService::uploadFile($data['image'], 'banners');

        try {
            $banner = Banner::create($data);
        } catch (Exception $e) {
            return response(['message' => 'Failed to create banner'], 500);
        }

        return response(['banner' => $banner]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner): Response
    {
        if (!$banner->exists) {
            return response(['message' => 'Banner not found'], 404);
        }

        return response(['banner' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, Banner $banner): Response
    {
        if (!$banner->exists) {
            return response(['message' => 'Banner not found'], 404);
        }

        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = fileUploadService::uploadFile($data['image'], 'banners');
        }

        if (FileUploadService::deleteFile($banner->image) && $banner->update($data)) {
            response(['message' => 'failed to update banner'], 500);
        }

        return response(['banner' => $banner->refresh()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner): Response
    {
        if (!$banner->exists) {
            return response(['message' => 'Banner not found'], 404);
        }

        if (FileUploadService::deleteFile($banner->image) && $banner->delete()) {
            return response(['message' => 'banner deleted successfully']);
        } else {
            return response(['message' => 'failed to delete banner'], 500);
        }
    }
}
