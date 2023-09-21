<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //todo add validation

        $stripe_price_ids = config('purchases.stripe_price_ids');

        return $request->user()->checkout([
            $stripe_price_ids[$request->type]
        ], [
            'metadata' => [
                'type' => $request->type
            ],
            'cancel_url' => route('purchases.cancelled'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }

    public function refund(Request $request, Purchase $purchase)
    {
        $request->user()->refund($purchase->payment_intent_id);

        return redirect()->back()->withSuccess('Refund successfully initiated.');
    }

    public function cancelled(Request $request)
    {
       return view('purchases.cancelled');
    }
}
