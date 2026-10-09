<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->subscriptions;
    }

    public function store(StoreSubscriptionRequest $request)
    {
        $validated = $request->validated();

        $subscription = $request->user()->subscriptions()->create($validated);

        return $subscription;
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return response()->noContent();
    }
}
