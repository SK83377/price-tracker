<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\SubscriptionService;

class SubscriptionController extends Controller
{
    protected $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function subscribe(Request $request)
    {
        $email = $request->input('email');
        $adUrl = $request->input('listing_url');
        
        $price = $this->subscriptionService->subscribe($email, $adUrl);

        return response()->json(['message' => $price]);
    }

    public function refreshPrices(Request $request)
    {
        
        $price = $this->subscriptionService->refreshPrices();

        return response()->json(['message' => 'refreshed']);
    }
}