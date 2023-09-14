<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerRequest;
use App\Models\Banner;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\FileUploadService;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        try {
            $perPage = $request->input('per_page', 10);
            $banners = Banner::paginate($perPage);

            if ($banners->isEmpty()) {
                return response([
                    'message' => 'No banners found'
                ], 404);
            }

            return response([
                'banners' => $banners
            ], 200);
        } catch (Exception) {
            return response([
                'error' => 'An error occurred while fetching banners'
            ], 500);
        }
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
            return response([
                'banner' => $banner
            ], 201);
        } catch (Exception) {
            return response([
                'message' => 'Failed to create banner'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner): Response
    {
        return response([
            'banner' => $banner
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, Banner $banner): Response
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $data['image'] = fileUploadService::uploadFile($data['image'], 'banners');
            FileUploadService::deleteFile($banner->getAttributes()['image']);
        }

        try {
            $banner->update($data);
            return response([
                'banner' => $banner->refresh()
            ], 200);
        } catch (Exception) {
            return response([
                'message' => 'Failed to update banner'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner): Response
    {
        FileUploadService::deleteFile($banner->getAttributes()['image']);

        if ($banner->delete()) {
            return response([
                'message' => 'Banner deleted successfully'
            ], 200);
        } else {
            return response([
                'message' => 'Failed to delete banner'
            ], 500);
        }
    }
}
