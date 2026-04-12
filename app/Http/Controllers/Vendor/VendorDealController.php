<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\DealTier;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorDealController extends Controller
{
    private function getVendor()
    {
        return Vendor::where('user_id', Auth::id())->first();
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $vendor = $this->getVendor();

        if (!$vendor) {
            return redirect()->route('login')
                             ->withErrors(['email' => 'No vendor profile found.']);
        }

        // Auto-cancel expired deals on page load
        $deals = Deal::where('vendor_id', $vendor->id)
                     ->with(['product', 'tiers'])
                     ->latest()
                     ->get();

        foreach ($deals as $deal) {
            if ($deal->checkAndCancel()) {
                // Notify vendor about auto-cancellation
                Notification::create([
                    'user_id' => Auth::id(),
                    'type'    => 'deal_cancelled',
                    'message' => "Your deal \"{$deal->title}\" was automatically cancelled because the minimum participant requirement was not met before the deadline.",
                    'is_read' => false,
                ]);
            }
        }

        // Refresh deals after potential cancellations
        $deals = Deal::where('vendor_id', $vendor->id)
                     ->with(['product', 'tiers'])
                     ->latest()
                     ->get();

        // Get unread notifications for vendor
        $notifications = Notification::where('user_id', Auth::id())
                                     ->where('is_read', false)
                                     ->latest()
                                     ->take(5)
                                     ->get();

        return view('vendor.deals.index', compact('deals', 'notifications'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $vendor = $this->getVendor();

        if (!$vendor) {
            $products = Product::where('status', 'active')->get();
        } else {
            $products = Product::where('vendor_id', $vendor->id)
                               ->where('status', 'active')
                               ->get();
            if ($products->isEmpty()) {
                $products = Product::where('status', 'active')->get();
            }
        }

        return view('vendor.deals.create', compact('products'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'product_name'      => 'required|string|max:255',
            'base_price'        => 'required|numeric|min:0',
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'min_participants'  => 'required|integer|min:2',
            'deadline'          => 'required|date|after:now',
            'tiers'             => 'required|array|min:1',
            'tiers.*.min_count' => 'required|integer|min:1',
            'tiers.*.price'     => 'required|numeric|min:0',
        ]);

        $vendor = $this->getVendor();

        if (!$vendor) {
            return back()->withErrors(['product_name' => 'No vendor profile found.']);
        }

        $product = Product::firstOrCreate(
            ['name' => $request->product_name, 'vendor_id' => $vendor->id],
            [
                'description'    => '',
                'image'          => null,
                'base_price'     => $request->base_price,
                'stock_quantity' => 100,
                'status'         => 'active',
            ]
        );

        $product->update(['base_price' => $request->base_price]);

        $sortedTiers  = collect($request->tiers)->sortBy('min_count');
        $initialPrice = $sortedTiers->first()['price'];

        $deal = Deal::create([
            'vendor_id'            => $vendor->id,
            'product_id'           => $product->id,
            'title'                => $request->title,
            'description'          => $request->description,
            'min_participants'     => $request->min_participants,
            'current_participants' => 0,
            'current_price'        => $initialPrice,
            'deadline'             => $request->deadline,
            'status'               => 'pending',
        ]);

        foreach ($request->tiers as $tier) {
            DealTier::create([
                'deal_id'   => $deal->id,
                'min_count' => $tier['min_count'],
                'price'     => $tier['price'],
            ]);
        }

        return redirect()->route('vendor.deals.index')
                         ->with('success', '✅ Deal created successfully with ' . count($request->tiers) . ' pricing tier(s)!');
    }

    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $vendor = $this->getVendor();
        $deal   = Deal::where('id', $id)
                      ->where('vendor_id', $vendor->id)
                      ->with(['product', 'tiers', 'participants'])
                      ->firstOrFail();

        // Auto cancel if expired
        $deal->checkAndCancel();
        $deal->refresh();

        return view('vendor.deals.show', compact('deal'));
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $vendor = $this->getVendor();
        $deal   = Deal::where('id', $id)
                      ->where('vendor_id', $vendor->id)
                      ->with('tiers')
                      ->firstOrFail();

        if ($deal->isCancelled()) {
            return redirect()->route('vendor.deals.index')
                             ->with('error', '❌ Cancelled deals cannot be edited.');
        }

        $products = Product::where('vendor_id', $vendor->id)
                           ->where('status', 'active')
                           ->get();

        return view('vendor.deals.edit', compact('deal', 'products'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'min_participants'  => 'required|integer|min:2',
            'deadline'          => 'required|date|after:now',
            'tiers'             => 'required|array|min:1',
            'tiers.*.min_count' => 'required|integer|min:1',
            'tiers.*.price'     => 'required|numeric|min:0',
        ]);

        $vendor = $this->getVendor();
        $deal   = Deal::where('id', $id)
                      ->where('vendor_id', $vendor->id)
                      ->firstOrFail();

        $sortedTiers  = collect($request->tiers)->sortBy('min_count');
        $initialPrice = $sortedTiers->first()['price'];

        $deal->update([
            'title'            => $request->title,
            'description'      => $request->description,
            'min_participants' => $request->min_participants,
            'current_price'    => $initialPrice,
            'deadline'         => $request->deadline,
        ]);

        $deal->tiers()->delete();
        foreach ($request->tiers as $tier) {
            DealTier::create([
                'deal_id'   => $deal->id,
                'min_count' => $tier['min_count'],
                'price'     => $tier['price'],
            ]);
        }

        return redirect()->route('vendor.deals.index')
                         ->with('success', '✅ Deal updated successfully!');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $vendor = $this->getVendor();
        $deal   = Deal::where('id', $id)
                      ->where('vendor_id', $vendor->id)
                      ->firstOrFail();

        // Notify participants about manual cancellation
        foreach ($deal->participants as $participant) {
            Notification::create([
                'user_id' => $participant->user_id,
                'type'    => 'deal_cancelled',
                'message' => "The deal \"{$deal->title}\" has been cancelled by the vendor.",
                'is_read' => false,
            ]);
        }

        $deal->update(['status' => 'cancelled']);
        $deal->tiers()->delete();
        $deal->delete();

        return redirect()->route('vendor.deals.index')
                         ->with('success', '🗑️ Deal cancelled and deleted successfully!');
    }

    // Mark notification as read
    public function markNotificationRead($id)
    {
        $notification = Notification::where('id', $id)
                                    ->where('user_id', Auth::id())
                                    ->first();
        if ($notification) {
            $notification->markAsRead();
        }
        return back();
    }
}