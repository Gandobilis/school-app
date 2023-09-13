<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Models\Subscription;
use Illuminate\Http\Response;

class SubscriptionController extends Controller
{

    public function subscribe(SubscriptionRequest $request): Response
    {
        Subscription::create($request->validated());

        return response([
            'message' => 'Subscribed successfully',
        ]);
    }

    public function unsubscribe(Subscription $subscription): Response
    {
        $subscription->delete();

        return response([
            'message' => 'Unsubscribed successfully',
        ]);
    }
}
