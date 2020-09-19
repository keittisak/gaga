<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Sku;
use App\Customer;
use DB;
use App\Libraries\Counter;
use App\Libraries\Image;
use DataTables;

class OrderController extends Controller
{
    public function index (Request $request)
    {
        $data = [
            'title_eng' => 'Orders',
            'title_th' => 'คำสั่งซื้อ',
            'statusInfo' => [
                'draft' => ['title' => 'ร่าง', 'icon' => 'fas fa-inbox', 'text_color' => 'text-blue'],
                'unpaid' => ['title' => 'ยังไม่จ่าย', 'icon' => 'far fa-times-circle', 'text_color' => 'text-red'],
                'transfered' => ['title' => 'โอนแล้ว', 'icon' => 'far fa-check-circle', 'text_color' => 'text-green'],
                'packing' => ['title' => 'กำลังแพ็ค', 'icon' => 'fas fa-tape', 'text_color' => 'text-info'],
                'paid' => ['title' => 'เตรียมส่ง', 'icon' => 'fas fa-archive', 'text_color' => 'text-muted'],
                'shipped' => ['title' => 'ส่งแล้ว', 'icon' => 'fas fa-shipping-fast', 'text_color' => 'text-success'],
                // 'voided' =>'ยกเลิก'
            ]
        ];
        return view('orders.index', $data);
    }

    public function history (Request $request)
    {
        $data = [
            'title_eng' => 'Order History',
            'title_th' => 'ประวัติออเดอร์',
            'statusInfo' => [
                'draft' => ['title' => 'ร่าง', 'icon' => 'fas fa-inbox', 'text_color' => 'text-blue'],
                'unpaid' => ['title' => 'ยังไม่จ่าย', 'icon' => 'far fa-times-circle', 'text_color' => 'text-red'],
                'transfered' => ['title' => 'โอนแล้ว', 'icon' => 'far fa-check-circle', 'text_color' => 'text-green'],
                'packing' => ['title' => 'กำลังแพ็ค', 'icon' => 'fas fa-tape', 'text_color' => 'text-info'],
                'paid' => ['title' => 'เตรียมส่ง', 'icon' => 'fas fa-archive', 'text_color' => 'text-muted'],
                'shipped' => ['title' => 'ส่งแล้ว', 'icon' => 'fas fa-shipping-fast', 'text_color' => 'text-success'],
                // 'voided' =>'ยกเลิก'
            ]
        ];
        return view('orders.history', $data);
    }

    public function data (Request $request)
    {
        $orders = Order::with(['payments'])
                    // ->when(isset($request['transfered_at']),function($q) use ($request){
                    //     $q->whereHas('payments', function($q) use ($request){
                    //         $request['transfered_at'] = str_replace('/','-',$request['transfered_at']);
                    //         $date = date('Y-m-d', strtotime($request['transfered_at'])); 
                    //         return $q->where(DB::raw('DATE(transfered_at)'), $date);
                    //     });
                    // })
                    ->when(isset($request['code']), function($q) use ($request){
                        return $q->where('code',strtolower($request['code']));
                    })
                    ->when(isset($request['customer_name']), function($q) use ($request){
                        return $q->where('shipping_full_name', 'like', '%'.$request['customer_name'].'%');
                    })
                    ->when(isset($request['created_at']), function($q) use ($request){
                        $request['created_at'] = str_replace('/','-',$request['created_at']);
                        $date = date('Y-m-d', strtotime($request['created_at']));
                        return $q->where(DB::raw('DATE(created_at)'), $date);
                    })
                    ->when(isset($request['scope']), function($q) use ($request){
                        return $q->where('status', $request['scope']);
                    })
                    ->get();
        return DataTables::of($orders)
                ->editColumn('code', function($order){
                    return strtoupper($order->code);
                })
                ->addColumn('checkbox', function($order){
                    return '<label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input checkbox-order" name="checkbox" value="'.$order->id.'">
                            <span class="custom-control-label"></span>
                            </label>';
                })
                ->escapeColumns([])
                ->make(true);
    }

    public function getOrderById(Request $request, int $id){
        $order = Order::with(['details','payments'])->findOrFail($id);
        // if(!$order){
        //     return abort(404);
        // }
        return $order;
    }

    public function overview(Request $request)
    {
        $orders = Order::select([
                        DB::raw('COUNT(*) as quantity'),
                        'status'
                    ])
                    ->groupBy('status')
                    ->get();
        $result = [
            'draft' => 0,
            'unpaid' => 0,
            'transfered' => 0,
            'packing' => 0,
            'paid' => 0,
            'shipped' => 0,
            'voided' => 0,
            'total' => 0
        ];
        foreach($orders as $order)
        {
            dd($order->status);
            $result[$order->status] += $order->quantity;
            $result['total'] += $order->quantity;
        }
        return $result;
    }

    public function create (Request $request)
    {
        $order = new Order();
        $data = [
            'action' => 'create',
            'title_en' => 'Add Order',
            'title_th' => 'เพิ่มคำสั่งซื้อ',
            'products' => Product::with(['skus' => function($q){
                                $q->where('status','active');
                            }])
                            ->where('status','active')
                            ->get(),
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
            'overpay' => [
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
                    'full_address' => $request->shipping_address,
                    // 'full_address' => $request->shipping_address.' '.$request->shipping_subdistrict_name,
                    // 'subdistrict_id' => $request->shipping_subdistrict_id,
                    'phone' => $request->shipping_phone
                ]);
                $customer = (new CustomerController)->store($_request);
                $data['customer_id'] = $customer->id;
            }else{
                $_request = new Request();
                $_request->merge([
                    'full_name' => $request->shipping_full_name,
                    'full_address' => $request->shipping_address,
                    // 'full_address' => $request->shipping_address.' '.$request->shipping_subdistrict_name,
                    // 'subdistrict_id' => $request->shipping_subdistrict_id,
                    'phone' => $request->shipping_phone
                ]);
                $customer = (new CustomerController)->update($_request, $request->customer_id);
                $data['customer_id'] = $request->customer_id;
            }

            $counter = new Counter();
            $code = $counter->generateCode('gg');
            $data['code'] = $code;
            $data['shipping_full_address'] = $data['shipping_address'];
            // $data['shipping_full_address'] = $data['shipping_address'].' '.$data['shipping_subdistrict_name'];
            $order = Order::create($data);
            $order->update([
                'link' => route('customerportal.index', base64_encode($order->id))
            ]);
            if (isset($request->details)){
                $discountAmount = $order->discount_amount;

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

                    $data['discount_amount'] = ($order->discount_amount/$order->total_quantity)*$data['quantity'];
                    
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
                if(!empty($data['date']) || !empty($data['image'])) {
                    $_request->merge($data);
                    $payment = (new PaymentController)->store($_request);
                    $order->payments()->sync([$payment->id]);
                }
                
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

    public function update (Request $request, int $id)
    {
        $order = Order::findOrFail($id);
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
            'overpay' => [
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
        $order = DB::transaction(function() use($request, $order, $data) {
            if (empty($request->customer_id)){
                $_request = new Request();
                $_request->merge([
                    'full_name' => $request->shipping_full_name,
                    'address' => $request->shipping_address,
                    'full_address' => $request->shipping_address,
                    // 'full_address' => $request->shipping_address.' '.$request->shipping_subdistrict_name,
                    // 'subdistrict_id' => $request->shipping_subdistrict_id,
                    'phone' => $request->shipping_phone
                ]);
                $customer = (new CustomerController)->store($_request);
                $data['customer_id'] = $customer->id;
            }else{
                $_request = new Request();
                $_request->merge([
                    'full_name' => $request->shipping_full_name,
                    'full_address' => $request->shipping_address,
                    // 'full_address' => $request->shipping_address.' '.$request->shipping_subdistrict_name,
                    // 'subdistrict_id' => $request->shipping_subdistrict_id,
                    'phone' => $request->shipping_phone
                ]);
                $customer = (new CustomerController)->update($_request, $request->customer_id);
                // $data['customer_id'] = $request->customer_id;
            }

            $data['shipping_full_address'] = $data['shipping_address'];
            $order->update($data);
            $discountAmount = $data['discount_amount'];
            $totalQuantity = $data['total_quantity'];
            if (isset($request->details)){
                $detailIds = [];
                foreach ($request->details as $data){
                    $_request = new Request();
                    if (isset($request->user()->id)){
                        $_request->merge(['created_by' => $request->user()->id, 'updated_by' => $request->user()->id]);
                    }
                    $sku = Sku::find($data['sku_id'])->toArray();
                    $data['sku_id'] = $sku['id'];
                    unset($sku['id']);
                    unset($sku['status']);
                    unset($sku['created_by']);
                    unset($sku['updated_by']);
                    unset($sku['created_at']);
                    unset($sku['updated_at']);
                    $data['discount_amount'] = ($discountAmount/$totalQuantity)*$data['quantity'];
                    $data = array_merge($data,$sku);
                    $_request->merge($data);
                    if(empty($data['id']))
                    {
                        $detail = (new OrderDetailController)->store($_request, $order->id);
                        $detailIds[] = $detail->id;
                    }else{
                        $detail = (new OrderDetailController)->update($_request, $order->id, $data['id']);
                        $detailIds[] = $detail->id;
                    }

                };

                $details = $order->details()->whereNotIn('id', $detailIds)->get();
                foreach ($details as $detail){
                    $_request = new Request();
                    (new OrderDetailController)->destroy($_request, $order->id, $detail->id);
                }
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

                if(empty($data['id'])){
                    if(!empty($data['date']) || !empty($data['image'])) {
                        $payment = (new PaymentController)->store($_request);
                        $order->payments()->sync([$payment->id]);
                    }
                }else{
                    if(!empty($data['date']) || !empty($data['image'])) {
                        $payment = (new PaymentController)->update($_request, $data['id']);
                        $order->payments()->detach($data['id']);
                    }
                }
            }
            return $order;
        });
        return $order;
    }

    public function changeStatus (Request $request)
    {
        $validate = [
            'ids' => [
                'required'
            ],
            'status' => [
                'in:draft,unpaid,transfered,packing,paid,shipped,voided'
            ]
        ];
        $request->validate($validate);
        $data = array_only($request->all(), array_keys($validate));
        $orders = DB::transaction(function() use ($request, $data) {
            $result = [];
            foreach($request->ids as $id)
            {
                $order = Order::findOrFail($id);
                $currentStatus = $order->status;
                $result[] = $order->update(['status' => $data['status']]);
            }
            return $result;
        });
        return response(['message' => 'success'], 200);
    }

    public function printLabel (Request $request)
    {
        $orders = Order::with(['details'])->whereIn('id',$request->orderIds)->orderBy('id', 'ASC')->get();
        $data = [
            'orders' => $orders
        ];
        return view('orders.label',$data);
    }
    public function labelToText (Request $request)
    {
        $orders = Order::with(['details'])->whereIn('id',$request->orderIds)->orderBy('id', 'ASC')->get();
        $data = [
            'orders' => $orders
        ];
        return view('orders.label_to_text',$data);
    }
    public function printList (Request $request)
    {
        $orders = Order::with(['details'])->whereIn('id',$request->orderIds)->get();
        $sumItems = array();
        $totalQuantity = 0;
        foreach($orders as $order){
            foreach($order->details as $item){
                if(isset($sumItems[$item->id])){
                    $sumItems[$item->sku_id]['quantity'] += $item->quantity;
                }else{
                    $sumItems[$item->sku_id] = [
                        'sku_id' => $item->sku_id,
                        'full_name' => $item->name,
                        'quantity' => $item->quantity
                    ];
                }
                $totalQuantity += $item->quantity;
            }
        }
        
        $data = [
            'orders' => $orders,
            'list' => [
                'items' => $sumItems,
                'total_quantity' => $totalQuantity
            ],
        ];
        return view('orders.list',$data);
    }
}
