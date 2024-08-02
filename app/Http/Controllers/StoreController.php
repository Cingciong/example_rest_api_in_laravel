<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Order;
class StoreController extends Controller
{
    public function getInventoryByStatus()
    {
        $inventory = Pet::select('status')
            ->selectRaw('count(*) as total')
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->all();

        return response()->json($inventory, 200);
    }
    public function placeOrder(Request $request)
    {

        try {
            $request->validate([
                'petId' => 'required|integer',
                'quantity' => 'required|integer',
                'shipDate' => 'required|date',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        }

        $pet = Pet::find($request->petId);
        if (!$pet || $pet->status != 'available') {
            return response()->json(['message' => 'Pet not available'], 400);
        }

        $pet->status = 'pending';
        $pet->save();

        $order = new Order;
        $order->pet_Id = $request->petId;
        $order->quantity = $request->quantity;
        $order->ship_date = $request->shipDate;
        $order->status = 'placed';
        $order->complete = 1;
        $order->save();

        return response()->json($order, 200);
    }
    public function find_purchase(Request $request)
    {
        try {
            $request->validate([
                'orderId' => 'required|integer',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        }

        $order = Order::find($request->orderId);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order, 200);
    }
    public function delete_order(Request $request)
    {
        try {
            $request->validate([
                'orderId' => 'required|integer',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        }

        $order = Order::find($request->orderId);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted'], 200);
    }
}
