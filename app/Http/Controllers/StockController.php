<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;

class StockController extends Controller
{
    public function index (Request $request){
        return view('stocks.index');
    }

    public function data(Request $request){
        $stocks = DB::table('stock_test')->get();
        return DataTables::of($stocks)->make(true);
    }

    public function store (Request $request){
        try{
            $stock = DB::transaction(function() use($request) {
                return DB::table('stock_test')->insert([
                    'product_name' => $request->product_name,
                    'quantity' => $request->quantity
                ]);
            });
            return response()->json($stock);
            
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }
        
    }

    public function update (Request $request, int $id){
        $stock = DB::table('stock_test')->find($id);
        if($request->option == 'minus'){
            $stock = DB::table('stock_test')->where('id', $id)->update([
                'quantity' => $stock->quantity - 1
            ]);
        }else{
            $stock = DB::table('stock_test')->where('id', $id)->update([
                'quantity' => $stock->quantity + 1
            ]);
        }
        return response()->json($stock);

    }

    public function destroy (Request $request, int $id){
        $stock = DB::table('stock_test')->where('id', $id)->delete();
        return response()->json($stock);
    }
}
