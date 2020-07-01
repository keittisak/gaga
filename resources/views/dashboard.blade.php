@extends('layouts.main')
@section('title',$title_eng)
@section('css')
    {{--  Css  --}}
    <style>
        .dataTables_wrapper .dataTables_filter {
            display: none;
        }
    </style>
@endsection
@section('content')
<div class="prompt-front">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <span class="h4 font-weight-normal">ข้อมูลการใช้งาน</span>
                        <button class="btn btn-primary btn-sm float-right"><i class="fas fa-sync-alt"></i> ปรับปรุงใหม่</button>
                    </div>
                    <span class="h5 font-weight-normal text-muted">แสดงข้อมูลวันที่ {{$latestTime}} / {{$latestDate}}</span>
                    
                </div>
            </div>
        </div>
    </div>
    @php
        $dates = [
            'today' => 'วันนี้',
            'yesterday' => 'เมื่อวาน',
            'this_month' => 'เดือนนี้',
            'last_mouth' => 'เดือนที่แล้ว'
        ];
    @endphp 
    <div class="row">
        @foreach ($overviewTotal as $key => $item)
        @php
            $date_title = 'วันนี้';    
            if($key == 'yesterday'){
                $date_title = 'เมื่อวาน';
            }else if($key == 'this_month'){
                $date_title = 'เดือนนี้';
            }else if($key == 'last_mouth'){
                $date_title = 'เดือนที่แล้ว';
            }
        @endphp
            <div class="col-sm-3 col-6">
                <div class="card">
                <div class="card-body text-center">
                    <div class="text-right text-muted">ยอดขาย</div>
                    <div class="display-4 font-weight-bold mb-4">{{$item['short_total_amount']}}</div>
                    <div class="h5">{{$date_title}}</div>
                    <div class="text-muted mb-4">{{$item['total_order']}} Order</div>
                </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">ออเดอร์</h4>
                    <div class="card-options">
                        @foreach ($dates as $key => $date)
                        <a href="#" class="btn {{ ($key=='today')?'btn-primary':'btn-secondary' }} btn-sm ml-2">{{$date}}</a>
                        @endforeach
                    </div>
                </div>
                <table class="table card-table">
                    <thead>
                        <tr>
                            <th>สถานะ</th>
                            <th class="text-right">จำนวน</th>
                            <th class="text-right">ยอดสุธิ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderByStatusTotal as $status => $order)
                        @if($status != 'total')
                            <tr>
                                <td><span class="{{ $order['text_color'] }} mr-2"><i class="{{ $order['icon'] }}"></i></span> {{ $order['title'] }}</td>
                                <td class="text-right">{{ $order['quantity'] }}</td>
                                <td class="text-right">{{ $order['net_total_amount'] }}</td>
                            </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td>จำนวนทั้งหมด</td>
                            <td class="text-right">{{ $orderByStatusTotal['total']['quantity'] }}</td>
                            <td class="text-right">{{ $orderByStatusTotal['total']['net_total_amount'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card" style="min-height:300px">
                <div class="card-header">
                    <h3 class="card-title">ยอดขายตามสินค้า</h3>
                    <div class="card-options">
                        <a href="#" class="btn btn-primary btn-sm">7 วัน</a>
                        <a href="#" class="btn btn-secondary btn-sm ml-2">30 วัน</a>
                        <a href="#" class="btn btn-secondary btn-sm ml-2">120 วัน</a>
                    </div>
                </div>
                <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อสินค้า</th>
                            <th>จำนวน</th>
                            <th>จำนวนเงิน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($salesByProduct as $key => $item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->full_name}}</td>
                                <td>{{number_format($item->quantity)}}</td>
                                <td>{{number_format($item->total_amount,2,'.',',')}}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title">ช่องทางสั่งซื้อ</h4>
                <div class="card-options">
                    <a href="#" class="btn btn-primary btn-sm">7 วัน</a>
                    <a href="#" class="btn btn-secondary btn-sm ml-2">30 วัน</a>
                    <a href="#" class="btn btn-secondary btn-sm ml-2">120 วัน</a>
                </div>
                </div>
                <table class="table card-table">
                <tbody>
                    @foreach ($saleChannel as $key => $item)
                    <tr>
                        <td width="1"><span class="{{$item['text_color']}}"><i class="{{ $item['icon'] }}"></i></span></td>
                        <td>{{ strtoupper($key) }}</td>
                    <td class="text-right"><span class="text-muted">{{ $item['pre'] }}%</span></td>
                    </tr>
                    @endforeach
{{-- 
                <tr>
                    <td><i class="fab fa-facebook-square"></i></td>
                    <td>Facebook</td>
                    <td class="text-right"><span class="text-muted">15%</span></td>
                </tr>
                <tr>
                    <td><i class="fab fa-instagram-square"></i></td>
                    <td>Instagram</td>
                    <td class="text-right"><span class="text-muted">7%</span></td>
                </tr>
                <tr>
                    <td><i class="fas fa-ellipsis-h"></i></td>
                    <td>Other</td>
                    <td class="text-right"><span class="text-muted">9%</span></td>
                </tr>
                <tr> --}}
                </tbody></table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>

</script>
@endsection