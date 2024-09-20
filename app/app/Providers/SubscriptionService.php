<?php

namespace App\Providers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Advertisment;
use App\Mail\PriceUpdateMail;
use Illuminate\Support\Facades\Mail;
use App\Providers\PriceParserService;

class SubscriptionService
{
    protected $priceParserService;

    public function __construct()
    {
        $this->priceParserService = new PriceParserService();
    }

    public function subscribe($email, $adUrl)
    {
        $price = $this->priceParserService->parsePriceFromUrl($adUrl);

        $user = User::firstOrCreate(['email' => $email]);

        $adv = Advertisment::firstOrCreate(['url' => $adUrl], ['price' => $price]);

        try {
            Subscription::firstOrCreate([
                'user_id' => $user->id,
                'advertisment_id' => $adv->id,
            ]);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            throw new \Exception('Database error: ' . $e->getMessage());
        }

        return $price;
    }

    public function refreshPrices()
    {
        $subscriptions = Subscription::with(['user', 'advertisment'])->get();

        $updatedPrices = [];

        foreach ($subscriptions as $subscription) {
            $currentPrice = $this->priceParserService->parsePriceFromUrl($subscription->advertisment->url);

            if ($currentPrice !== $subscription->advertisment->price) {
                $subscription->advertisment->update(['price' => $currentPrice]);

                $updatedPrices[] = [
                    'url' => $subscription->advertisment->url,
                    'email' => $subscription->user->email,
                    'price' => $currentPrice,
                ];
            }
        }

        // Send email if there are any updates
        if (count($updatedPrices) > 0) {
            $this->sendPriceUpdateEmail($updatedPrices);
        }
    }

    protected function sendPriceUpdateEmail($updatedPrices)
    {
        $emails = array_unique(array_column($updatedPrices, 'email'));

        foreach ($emails as $email) {
            Mail::to($email)->send(new PriceUpdateMail($updatedPrices));
        }
    }

    private function getUserSubscriptions($userId)
    {
        return Subscription::where('user_id', $userId)->with('advertisment')->get();
    }
}