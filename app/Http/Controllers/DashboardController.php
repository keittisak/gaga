<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Order;
use App\OrderDetail;
use App\Product;
use App\Sku;
use App\Customer;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index (Request $request)
    {
        $monthShortTh = ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค." , "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."];
        $latestDate = Carbon::now()->format('d').' '.$monthShortTh[(Carbon::now()->format('m')-1)].' '.Carbon::now()->format('Y');
        $latestTime = Carbon::now()->format('H:i');
        $_request = new Request;
        $salesByProduct = $this->SalesByProduct($_request);
        $overviewTotal = $this->overviewTotal($_request);
        $data = $data = [
            'title_eng' => 'Dashboard',
            'title_th' => 'Dashboard',
            'latestDate' => $latestDate,
            'latestTime' => $latestTime,
            'overviewTotal' => $overviewTotal,
            'salesByProduct' => $salesByProduct
        ];
        return view('dashboard',$data);
    }

    public function overviewTotal (Request $request)
    {
        $dates = ['today','yesterday', 'this_month', 'last_mouth'];
        $response = [];
        foreach($dates as $date){
            $result = Order::select([
                DB::raw('COUNT(*) as total_order'),
                DB::raw('SUM(net_total_amount) as net_total_amount'),
            ])
            ->when($date, function($q) use ($date){
                if($date == 'today'){
                    $q->whereDate('created_at', Carbon::now()->format('Y-m-d'));
                }else if($date == 'yesterday'){
                    $q->whereDate('created_at', Carbon::now()->subDays(1)->format('Y-m-d'));
                }else if($date == 'this_month'){
                    $q->whereMonth('created_at',Carbon::now()->format('m'))->whereYear('created_at',Carbon::now()->format('Y'));
                }else if($date == 'last_mouth'){
                    $q->whereMonth('created_at', Carbon::now()->subMonth()->format('m'))->whereYear('created_at',Carbon::now()->format('Y'));
                }
                return $q;
            })
            ->where('status', '!=', 'voided')
            ->first();
            $shortTotalAmount = 0;
            if($result->net_total_amount){
                $shortTotalAmount = number_format($result->net_total_amount/1000,2,'.','').'K';
                if($result->net_total_amount >= 1000000){
                    $shortTotalAmount = number_format($result->net_total_amount/1000000,2,'.','').'M';
                }
            }
            $response[$date] = [
                'total_order' => $result->total_order,
                'total_amount' => ($result->net_total_amount)?$result->net_total_amount:0,
                'short_total_amount' => $shortTotalAmount
            ];
        }
        return $response;
    }

    public function SalesByProduct (Request $request)
    {
        $result = OrderDetail::select([
            'sku_id',
            'full_name',
            DB::raw('SUM(quantity) as quantity'),
            DB::raw('SUM(total_amount) as total_amount')
        ])
        ->whereHas('order', function($q) use ($request){
            $q->where('status', '!=', 'voided');
        })
        ->when($request->date, function($q) use ($request){
            $startDate = Carbon::now()->subDays($request->date)->format('Y-m-d');
            $endDate = Carbon::now()->format('Y-m-d');
            return $q->whereBetween(DB::raw('DATE(created_at'), [$startDate,$endDate]);
        })
        ->groupBy('sku_id')
        ->orderBy('total_amount', 'desc')
        ->get();
        return $result;
    }


}
