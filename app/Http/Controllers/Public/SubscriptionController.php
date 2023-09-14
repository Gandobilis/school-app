<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\SubscriptionRequest;
use App\Models\Subscription;
use Exception;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::where('confirmed', true)->get();

        return response(['subscriptions' => $subscriptions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function subscribe(SubscriptionRequest $request): Response
    {
        $data = $request->validated();
        Subscription::create($data);

        return response(['message' => 'Subscribed successfully',], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function unsubscribe(Subscription $subscription): Response
    {
        $subscription->delete();

        return response(['message' => 'Unsubscribed successfully']);
    }
}
