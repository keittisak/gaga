<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use App\Sku;
use App\Customer;
use DB;
use App\Libraries\Counter;
use App\Libraries\Image;

class OrderController extends Controller
{
    public function create (Request $request)
    {
        $order = new Order();
        $data = [
            'action' => 'create',
            'title_en' => 'Add Order',
            'title_th' => 'เพิ่มคำสั่งซื้อ',
            'products' => Product::with(['skus'])->get(),
            'order' => $order
        ];
        return view('orders.form', $data);
    }

    public function store (Request $request)
    {
        if (isset($request->user()->id)){
            $request->merge(array('created_by' => $request->user()->id));
            $request->merge(array('updated_by' => $request->user()->id));
        }
        $validate = [
            'shipping_phone' => [
                'required',
                'nullable'
            ],
            'shipping_full_name' => [
                'nullable'
            ],
            'shipping_address' => [
                'nullable'
            ],
            'shipping_subdistrict_id' => [
                'integer',
            ],
            'shipping_subdistrict_name' => [
                'nullable'
            ],
            'details.*' => [

            ],
            'total_quantity' => [
                'numeric',
                'min:0'
            ],
            'total_amount' => [
                'numeric',
                'min:0'
            ],
            'shipping_fee' => [
                'numeric',
                'min:0'
            ],
            'discount_amount' => [
                'numeric',
                'min:0'
            ],
            'net_total_amount' => [
                'numeric',
                'min:0'
            ],
            'payments.*' => [

            ],
            'sale_channel' => [
                'in:line,facebook,instagram,other'
            ],
            'payment_method_id' => [
                'nullable',
                'integer',
            ],
            'shipment_method_id' => [
                'nullable',
                'integer',
            ],
            'remark' => [

            ],
            'created_by' => [
                'nullable',
                'integer'
            ],
            'updated_by' => [
                'nullable',
                'integer'
            ],
            'created_at' => [
                
            ]
        ];
        // dd($request->all());
        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        $order = DB::transaction(function() use($request, $data) {
            if (empty($request->customer_id)){
                $_request = new Request();
                $_request->merge([
                    'full_name' => $request->shipping_full_name,
                    'address' => $request->shipping_address,
                    'full_address' => $request->shipping_address.' '.$request->shipping_subdistrict_name,
                    'subdistrict_id' => $request->shipping_subdistrict_id,
                    'phone' => $request->shipping_phone
                ]);
                $customer = (new CustomerController)->store($_request);
                $data['customer_id'] = $customer->id;
            }else{
                $_request = new Request();
                $_request->merge([
                    'full_name' => $request->shipping_full_name,
                    'full_address' => $request->shipping_address.' '.$request->shipping_subdistrict_name,
                    'subdistrict_id' => $request->shipping_subdistrict_id,
                    'phone' => $request->shipping_phone
                ]);
                $customer = (new CustomerController)->update($_request, $request->customer_id);
            }

            $counter = new Counter();
            $code = $counter->generateCode('gg');
            $data['code'] = $code;
            $data['shipping_full_address'] = $data['shipping_address'].' '.$data['shipping_subdistrict_name'];

            $order = Order::create($data);
            if (isset($request->details)){
                foreach ($request->details as $data){
                    $_request = new Request();
                    $sku = Sku::find($data['sku_id'])->toArray();
                    $data['sku_id'] = $sku['id'];
                    unset($sku['id']);
                    unset($sku['status']);
                    unset($sku['created_by']);
                    unset($sku['updated_by']);
                    unset($sku['created_at']);
                    unset($sku['updated_at']);
                    
                    $data = array_merge($data,$sku);
                    $_request->merge($data);
                    (new OrderDetailController)->store($_request, $order->id);
                };
                
            }

            if (isset($request->payments)){
                $data = $request->payments;
                $_request = new Request();
                if ($request->hasFile('image_transfer')){
                    $image = new Image();
                    $file = $request->file('image_transfer');
                    $path = 'images/slips/'.date('Ymd');
                    $imageUrl = $image->upload($file, $path);
                    $data['image'] = $imageUrl;
                }
                $data['date'] = str_replace('/','-',$data['date']);
                $transfer_at = date('Y-m-d H:i:s', strtotime($data['date'].' '.$data['time']));
                $data['transfered_at'] = $transfer_at;
                $_request->merge($data);
                $payment = (new PaymentController)->store($_request);
                $order->payments()->sync([$payment->id]);
            }
            return $order;
        });
        return response($order,'201');
    }

    public function edit (Request $request, int $id)
    {
        $order = new Order();
        $order = $order->with(['details.product.skus','payments'])->findOrFail($id);
        $data = [
            'action' => 'update',
            'title_en' => 'Update Order',
            'title_th' => 'แก้ไขคำสั่งซื้อ',
            'products' => Product::with(['skus'])->get(),
            'order' => $order
        ];
        return view('orders.form', $data);
    }
}
