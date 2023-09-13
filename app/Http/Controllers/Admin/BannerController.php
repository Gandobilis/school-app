<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\Response;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response([
            'banners' => Banner::with('translation')
                ->paginate(4)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request): Response
    {
        $banner = Banner::create($request->validated());
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
        $banner->update($request->validated());
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
