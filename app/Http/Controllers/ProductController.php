<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use DB;

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
        return view('products.form');
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
        $request->merge(array('slug' => str_slug($request->name, '-')));
        if(isset($request->type)){
            $request->merge(array('type' => 'variable'));
        }else{
            $request->merge(array('type' => 'simple'));
        }

        $request->merge(array('status' => 'active'));

        $validate = [
            'slug' => [
                'required',
                'unique:products,slug',
                'max:255'
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
            $product = new Product();
            $product = $product->create($data);
            if ($request->type == "variable"){
                if (isset($request->variants)){
                    foreach($request->variants as $key => $data){
                        $_request = new Request();
                        $data['name'] = 'variant-'.$key;
                        $_request->merge($data);
                        if (isset($request->user()->id)){
                            $_request->merge(['created_by' => $request->user()->id, 'updated_by' => $request->user()->id]);
                        }
                        (new VariantController)->store($_request, $product->id);
                    }
                }
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
        //
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
        //
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
