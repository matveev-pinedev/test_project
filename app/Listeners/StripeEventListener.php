<?php

namespace App\Listeners;

use App\Events\UserLicenseAccountSubscribed;
use App\Events\UserLicenseAccountUnsubscribed;
use App\Events\UserSubscribed;
use App\Events\UserUnsubscribed;
use App\Mail\PurchaseCompleted;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;
use Laravel\Cashier\Subscription;


class StripeEventListener
{
    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        match ($event->payload['type']) {
            'checkout.session.completed', => $this->checkout_session_completed($event->payload['data']['object']),
            'charge.refunded', => $this->charge_refunded($event->payload['data']['object']),
            default => function () {
            }
        };
    }

    private function checkout_session_completed($checkout_session)
    {
        if($checkout_session['payment_status'] != 'paid') return;

        $user = User::where('stripe_id', $checkout_session['customer'])->first();

        // $stripe = Cashier::stripe();

        // $payment_intent = $stripe->paymentIntents->retrieve(
        //     $checkout_session['payment_intent']
        // );

        // $payment_method = $stripe->paymentMethods->retrieve(
        //     $payment_intent->payment_method
        // );

        // $user->purchases()->create([
        //     'type' => $checkout_session['metadata']['type'],
        //     'payment_intent_id' => $checkout_session['payment_intent'],
        //     'pm_last_four' => $payment_method->card->last4,
        // ]);

        // $role_name = match ($checkout_session['metadata']['type']) {
        //     'b2b' => 'b2b_customer',
        //     'b2c' => 'b2c_customer',
        //     default => null
        // };

        // if($role_name == null) return;

        // $user->assignRole($role_name);
        
        Mail::to($user)->send(new PurchaseCompleted($user));
    }
    
    private function charge_refunded($charge)
    {
        $user = User::where('stripe_id', $charge['customer'])->first();

        $purchase = $user->purchases()->where('payment_intent_id', $charge['payment_intent'])->first();

        if($purchase == null) return;

        $purchase->update([
            'is_refunded' => true,
        ]);

        $role_name = match ($purchase->type) {
            'b2b' => 'b2b_customer',
            'b2c' => 'b2c_customer',
            default => null
        };        

        if($role_name == null) return;

        $user->removeRole($role_name);
    }
}
