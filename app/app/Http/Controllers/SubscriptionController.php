<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SubscriptionService;

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
        $adUrl = $request->input('adUrl');
        
        $this->subscriptionService->subscribe($email, $adUrl);

        return response()->json(['message' => 'Subscription created successfully!']);
    }
}