<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\BuyerResource;
use App\Exports\BuyersExport;
use Maatwebsite\Excel\Facades\Excel;

class ApiBuyerController extends Controller
{
    public function buyers(Request $request){
        $keyword = $request->input('search');

        $buyers = User::when($keyword, function($query, $keyword){
                $query->where('name', 'like', '%'.$keyword.'%');
            })
            ->orderByDesc('id')
            ->paginate(6);
        return BuyerResource::collection($buyers);
    }

    public function delete(string $id)
    {
        $buyer = User::findOrFail($id);
        $buyer->delete();
        return response()->json(['success' => 'Delete buyer successfully!']);    
    }

    public function trash(){
        $buyers = User::onlyTrashed()->orderByDesc('id')->paginate(6);
        return BuyerResource::collection($buyers);
    }

    public function restore(string $id)
    {
        $buyer = User::withTrashed()->findOrFail($id);
        if(isset($buyer)){
            $buyer->restore();
            return response()->json(['success' => 'Restore buyer successfully!']);    
        }
    }
    public function remove(string $id)
    {
        $buyer = User::withTrashed()->findOrFail($id);
        $buyer->forceDelete();
        return response()->json(['success' => 'Remove buyer successfully!']);    
    }

    public function export(){
        return Excel::download(new BuyersExport, 'buyers.xlsx');
    }

}
