<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;

class OrderController extends Controller
{
    public function create (Request $request)
    {
        $data = [
            'action' => 'create',
            'title_en' => 'Add Order',
            'title_th' => 'เพิ่มคำสั่งซื้อ',
            'products' => Product::with(['skus'])->get()
        ];
        return view('orders.form', $data);
    }

    public function store (Request $request)
    {
        dd($request->all());
    }
}
