<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Sku;
use App\Product;
use DB;
use DataTables;


class StockController extends Controller
{

    public function index (Request $request)
    {
        $_request = new Request();
        $data = $this->data($_request);
        return view('stocks.index',[
            'items' => $data->getData()
        ]);
    }

    public function data (Request $request)
    {
        $data = collect([]);
        $products = Product::with(['skus'])->get()->toArray();
        foreach($products as $key => $item)
        {
            foreach($item['skus'] as $index => $sku)
            {
                $stock = Stock::where('sku', $sku['sku'])->first()->toArray();
                $products[$key]['skus'][$index]['stock'] = $stock;
            }
            $data->push($products[$key]);
            
        }
        return response()->json($data,200);
        return DataTables::of($data)->make(true);
    }

    public function store(Request $request, string $sku)
    {
        $request->merge(array('sku' => $sku));
 
        $validate = [
            //stock table
            'sku' => [
                'required',
                'unique:stocks,sku',
                'exists:skus,sku',
                'max:30'
            ],
            'available' => [
                'integer'
            ],
            'draft' => [
                'integer'
            ],
            'onhand' => [
                'integer'
            ]
        ];
        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        $stock = new Stock();
        
        return $stock->create($data);
    }

    public function update(Request $request, string $id)
    {    
        $sku = $request->sku;
        $validate = [
            //stock table
            'sku' => [
                'required',
                function($attribute, $value, $fail) use($sku) {
                    $total = Stock::where('sku', '!=', $sku)
                                ->where('sku', $value)
                                ->count();
                    if ($total > 0){
                        return $fail($attribute.' is invalid.');
                    }
                },
                'exists:skus,sku',
                'max:30'
            ],
            'action' => [
                'required',
                'in:set,add'
            ],
            'quantity' => [
                'integer',
                'min:0'
            ],
            'remark' => [
                
            ],
            'updated_by' => [
                'integer'
            ]
        ];
        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));

        $stock = DB::transaction(function() use($request,$data,$id) {
            $stock = Stock::find($id);
            if($data['action'] == 'add'){
                $response = $stock->fillIn($data['quantity'], ['remark'=>$data['remark']]);
            }else{
                
                if($data['quantity'] > $stock->onhand){
                    $quantity = $data['quantity'] - $stock->onhand;
                    $response = $stock->fillIn($quantity, ['remark'=>$data['remark']]);
                }else{
                    $quantity = $stock->onhand - $data['quantity'];
                    $response = $stock->takeOut($quantity, ['remark'=>$data['remark']]);
                }
            }
            $stock->update($data);
            return $stock->first();
        });

        return $stock;
    }

}
