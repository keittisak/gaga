<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Variant;
use App\Sku;
use DB;
use App\Libraries\Counter;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('products.index');
    }

    public function data(Reqeust $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'action' => 'create',
            'title' => 'เพิ่มสินค้า',
            'product' => new Product
        ];
        return view('products.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request->user()->id)){
            $request->merge(array('created_by' => $request->user()->id));
            $request->merge(array('updated_by' => $request->user()->id));
        }
        $request->merge(array('slug' => str_slug($request->slug, '-')));
        if(isset($request->type)){
            $request->merge(array('type' => 'variable'));
        }else{
            $request->merge(array('type' => 'simple'));
        }

        $request->merge(array('status' => 'active'));

        $validate = [
            'slug' => [
                // 'required',
                // 'unique:products,slug',
                // 'max:255'
            ],
            'name' => [
                'required',
                'max:255'
            ],
            'name_en' => [
                'nullable',
                'max:255'
            ],
            'description' => [
                'nullable'
            ],
            'description_en' => [
                'nullable'
            ],
            'short_description' => [
                'nullable'
            ],
            'short_description_en' => [
                'nullable'
            ],
            'brand_id' => [
                'nullable',
                'integer',
                'exists:brands,id'
            ],
            'image' => [
                'nullable'
            ],
            'gallery_id' => [
                'nullable',
                'integer'
            ],
            'type' => [
                'in:simple,variable,group'
            ],
            'variants.*' => [
                
            ],
            'status' => [
                'in:active,inactive'
            ],
            'created_by' => [
                'nullable',
                'integer'
            ],
            'updated_by' => [
                'nullable',
                'integer'
            ],
        ];

        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        $product = DB::transaction(function() use($request, $data) {
            $counter = new Counter;
            $product = new Product();
            $product = $product->create($data);
            if ($request->type == "variable"){
                foreach($request->skus as $key => $data){
                    if(isset($data['active'])){
                        $_request = new Request();
                        $sku = $counter->generateCode('sku',0,3);
                        $data['sku'] = $sku;
                        $data['product_id'] = $product->id;

                        $_request->merge($data);
                        if (isset($request->user()->id)){
                            $_request->merge(['created_by' => $request->user()->id, 'updated_by' => $request->user()->id]);
                        }
                        (new SkuController)->store($_request);
                    }
                    
                }
                // if (isset($request->variants)){
                //     foreach($request->variants as $key => $data){
                //         $_request = new Request();
                //         $_request->merge($data);
                //         if (isset($request->user()->id)){
                //             $_request->merge(['created_by' => $request->user()->id, 'updated_by' => $request->user()->id]);
                //         }
                //         $variant = (new VariantController)->store($_request, $product->id);
                //     }

                //     $variants = $variant->with('options')->where('product_id', $product->id)->get();
                //     $set_option_ids = [];
                //     if($variants){
                //         for($i = 0; $i < count($variants[0]['options']); $i++){
                //             if(isset($variants[1])){
                //                 for($j = 0; $j < count($variants[1]['options']); $j++){
                //                     $set_option_ids[] = [
                //                         $variants[0]['options'][$i]['id'],
                //                         $variants[1]['options'][$j]['id'],
                //                     ];
                //                 }
                //             }else{
                //                 $set_option_ids[] = [
                //                     $variants[0]['options'][$i]['id']
                //                 ];
                //             }
                //         }
                //     }

                //     foreach($request->skus as $key => $data){
                //         $_request = new Request();
                //         $sku = $counter->generateCode('sku',0,3);
                //         $data['sku'] = $sku;
                //         $data['product_id'] = $product->id;
                //         if(isset($set_option_ids[$key])){
                //             $data['option_ids'] = $set_option_ids[$key];
                //         }
                //         $_request->merge($data);
                //         if (isset($request->user()->id)){
                //             $_request->merge(['created_by' => $request->user()->id, 'updated_by' => $request->user()->id]);
                //         }
                //         (new SkuController)->store($_request);
                //     }
                // }
            }else if($request->type == 'simple'){
                $_request = new Request();
                $sku = $counter->generateCode('sku',0,3);
                $data['sku'] = $sku;
                $data['product_id'] = $product->id;
                $data['price'] = $request->price;
                $data['full_price'] = $request->full_price;
                $data['cost'] = $request->cost;
                $data['call_unit'] = $request->call_unit;
                $_request->merge($data);
                (new SkuController)->store($_request);
            }
            return $product;
        });
        return response($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with(['skus'])->findOrFail($id);
        $variants = $product->variants()->with('options')->get();
        $data = [
            'action' => 'update',
            'title' => 'แก้ไขสินค้า',
            'product' => $product,
            'variants' => $variants
        ];
        return view('products.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $product = Product::findOrFail($id);
        if (isset($request->user()->id)){
            $request->merge(array('updated_by' => $request->user()->id));
        }
        $request->merge(array('slug' => str_slug($request->slug, '-')));
        if(isset($request->type)){
            $request->merge(array('type' => 'variable'));
        }else{
            $request->merge(array('type' => 'simple'));
        }

        $request->merge(array('status' => 'active'));

        $validate = [
            'slug' => [
                // 'required',
                // 'unique:products,slug',
                // 'max:255'
            ],
            'name' => [
                'required',
                'max:255'
            ],
            'name_en' => [
                'nullable',
                'max:255'
            ],
            'description' => [
                'nullable'
            ],
            'description_en' => [
                'nullable'
            ],
            'short_description' => [
                'nullable'
            ],
            'short_description_en' => [
                'nullable'
            ],
            'brand_id' => [
                'nullable',
                'integer',
                'exists:brands,id'
            ],
            'image' => [
                'nullable'
            ],
            'gallery_id' => [
                'nullable',
                'integer'
            ],
            'type' => [
                'in:simple,variable,group'
            ],
            'variants.*' => [
                
            ],
            'status' => [
                'in:active,inactive'
            ],
            'created_by' => [
                'nullable',
                'integer'
            ],
            'updated_by' => [
                'nullable',
                'integer'
            ],
        ];

        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        $product = DB::transaction(function() use($request, $product, $data) {
            $counter = new Counter;
            $result = $product->update($data);
            if ($request->type == "variable"){
                $productSkus = [];
                foreach($request->skus as $key => $data){
                    $_request = new Request();
                    if(isset($data['active'])){
                        $data['product_id'] = $product->id;
                        if(empty($data['sku'])){
                            if (isset($request->user()->id)){
                                $_request->merge(['created_by' => $request->user()->id, 'updated_by' => $request->user()->id]);
                            }
                            $sku = $counter->generateCode('sku',0,3);
                            $data['sku'] = $sku;
                            $_request->merge($data);
                            $sku = (new SkuController)->store($_request);
                            $productSkus[] = $sku->sku;
                        }else{
                            if (isset($request->user()->id)){
                                $_request->merge(['updated_by' => $request->user()->id]);
                            }
                            $_request->merge($data);
                            $sku = (new SkuController)->update($_request, $data['sku']);
                            $productSkus[] = $sku->sku;
                        }
                    }
                }
                $skus = $product->skus()->whereNotIn('sku', $productSkus)->get();
                foreach ($skus as $item){
                    $_request = new Request();
                    (new SkuController)->destroy($item->sku);
                }

            }else if($request->type == 'simple'){
                $_request = new Request();
                $data['product_id'] = $product->id;
                $data['price'] = $request->price;
                $data['full_price'] = $request->full_price;
                $data['cost'] = $request->cost;
                $data['call_unit'] = $request->call_unit;
                $_request->merge($data);
                (new SkuController)->update($_request, $request->sku);
                $skus = $product->skus()->whereNotIn('sku', [$request->sku])->get();
                foreach ($skus as $item){
                    $_request = new Request();
                    (new SkuController)->destroy($item->sku);
                }
            }
            return $result;
        });
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
