<?php

namespace App\Http\Controllers;

use App\ShopifyApi;
use App\Order;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrdersController extends Controller
{
    /**
     * Display a list of all orders, synchronize if necessary
     *
     * @param ShopifyApi $api
     * @return Application|Factory|View
     * @throws Exception
     */
    public function __invoke(ShopifyApi $api)
    {
        // Get the last updated time of the most recent order
        $last_sync = DB::table('orders')->latest('order_updated')->value('order_updated');

        // If there's a last sync, get the most up to date versions
        if ($last_sync) {
            // Shopify expects dates in EDT
            $carbon = new Carbon($last_sync, '-0400');

            // Get all new records updated since 1 second after the most recent local record
            $carbon->addSeconds(1);

            $shopify_orders = $api->getOrders(['updated_at_min' => $carbon->toIso8601String()]);
        } else {
            $shopify_orders = $api->getOrders();
        }

        // Update the database for the new orders
        foreach ($shopify_orders as $row) {
            $order = Order::firstOrNew([
                'id' => $row->id,
            ]);

            $order->name = $row->name;
            $order->total_price = $row->total_price;
            $order->order_created = $row->created_at;
            $order->order_updated = $row->updated_at;
            $order->json = json_encode($row);

            $order->save();
        }

        // Retrieve all the orders
        $orders = Order::all();

        return view('orders', ['orders' => $orders]);
    }
}
