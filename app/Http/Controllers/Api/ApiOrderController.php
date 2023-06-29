<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class ApiOrderController extends Controller
{
    public function orders(Request $request){
        $keyword = $request->input('search');

        $orders = Order::when($keyword, function($query, $keyword){
                $query->where('name', 'like', '%'.$keyword.'%');
            })
            ->orderByDesc('id')
            ->paginate(6);
        return OrderResource::collection($orders);
    }

    public function show($id){
        $order = Order::find($id);
        return OrderResource::make($order);
    }

    public function delete(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['success' => 'Delete product successfully!']);    
    }

    public function trash(){
        $orders = Order::onlyTrashed()->orderByDesc('id')->paginate(6);
        return OrderResource::collection($orders);
    }

    public function restore(string $id)
    {
        $order = Order::withTrashed()->findOrFail($id);
        if(isset($order)){
            $order->restore();
            return response()->json(['success' => 'Restore order successfully!']);    
        }
    }
    public function remove(string $id)
    {
        $order = order::withTrashed()->findOrFail($id);
        $order->forceDelete();
        return response()->json(['success' => 'Remove order successfully!']);    
    }

    public function export(){
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }

    public function orderHistory(){
        $orders = Order::where('user_id', \Auth::id())->paginate(5);
        return OrderResource::collection($orders);
    }
}
