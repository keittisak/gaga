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
<div class="page-header">
    <h1 class="page-title prompt-front">
        {{$title_th}}
    </h1>
</div>
<div class="row row-cards prompt-front">
    @foreach ($statusInfo as $status => $title)
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    @if($status == 'draft')
                    <div class="text-right text-blue">
                    <i class="fas fa-inbox"></i>
                    @elseif($status == 'unpaid')
                    <div class="text-right text-red">
                    <i class="far fa-times-circle"></i>
                    @elseif($status == 'transfered')
                    <div class="text-right text-green">
                    <i class="far fa-check-circle"></i>
                    @elseif($status == 'packing')
                    <div class="text-right text-info">
                    <i class="fas fa-tape"></i>
                    @elseif($status == 'paid')
                    <div class="text-right text-muted">
                    <i class="fas fa-archive"></i>
                    @elseif($status == 'shipped')
                    <div class="text-right text-success">
                    <i class="fas fa-shipping-fast"></i>
                    @endif
                    </div>
                <div class="h1 m-0 overview-text-{{$status}}">43</div>
                <div class="text-muted">{{ $title }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row-main row d-none d-md-flex prompt-front">
    <div class="col-12 col-md-12 col-lg-8 mb-5">
        <div class="row gutters-xs table-search">
            <div class="col">
                <select class="form-control status" name="status" style="text-align-last: center">
                    @foreach ($statusInfo as $status => $title)
                    <option value="{{$status}}" @if(Request::get('scope') == $status) checked @endif>{{$title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <input type="text" class="form-control text-search" placeholder="ค้นหา ...">
            </div>
            <span class="col-auto">
                <button class="btn btn-secondary btn-search" type="button"><i class="fe fe-search"></i></button>
            </span>
            <span class="col-auto">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#advancedSearchModal"><i class="fe fe-sliders"></i> ค้นหาขั้นสูง</button>
            </span>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-4 text-right mb-5  prompt-front">
        <div class="dropdown">
            <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle btn-change-status" aria-expanded="true">เปลี่ยนสถานะ</button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" x-placement="bottom-end" style="position: absolute; transform: translate3d(-56px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
              <a class="dropdown-item btn-change-status-items" data-status="draft">ร่าง</a>
              <a class="dropdown-item btn-change-status-items" data-status="unpaid">ยังไม่จ่าย</a>
              <a class="dropdown-item btn-change-status-items" data-status="shipped">ส่งแล้ว</a>
            </div>
        </div>
        <div class="dropdown">
            <button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle btn-print" aria-expanded="true">พิมพ์</button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" x-placement="bottom-end" style="position: absolute; transform: translate3d(-56px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
              <a class="dropdown-item btn-print-items" data-type="label">ใบปะหน้ากล่อง</a>
              <a class="dropdown-item btn-print-items" data-type="list">รายการแพ็คของ</a>
            </div>
        </div>
    </div>
</div>

<div class="row-main">
    <div class="row d-md-none prompt-front">
        <div class="col-12 ">
            <div class="form-group">
                <select class="form-control status" name="status" style="text-align-last: center">
                    @foreach ($statusInfo as $status => $title)
                    <option value="{{$status}}" @if(Request::get('scope') == $status) checked @endif>{{$title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group table-search">
                <div class="input-group mb-3">
                    <input type="text" class="form-control text-search" placeholder="ค้นหา ...">
                    <span class="input-group-append">
                        <button class="btn btn-primary pl-3 pr-3 btn-search" type="button"><i class="fe fe-search"></i></button>
                    </span>
                    <span class="input-group-append">
                        <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#advancedSearchModal">ค้นหาขั้นสูง</button>
                    </span>
                </div>
            </div>
            
        </div>
    </div>

    <div class="row d-md-none mb-5 prompt-front">
        <div class="col-6">
            <div class="dropdown w-100">
                <button data-toggle="dropdown" type="button" class="btn btn-outline-primary btn-block dropdown-toggle btn-change-status" aria-expanded="true">เปลี่ยนสถานะ</button>
                <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end" style="position: absolute; transform: translate3d(-56px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a class="dropdown-item btn-change-status-items" data-status="draft">ร่าง</a>
                    <a class="dropdown-item btn-change-status-items" data-status="unpaid">ยังไม่จ่าย</a>
                    <a class="dropdown-item btn-change-status-items" data-status="shipped">ส่งแล้ว</a>
                </div>
            </div>
        </div>
        <div class="col-6 ">
            <div class="dropdown w-100">
                <button data-toggle="dropdown" type="button" class="btn btn-outline-primary btn-block dropdown-toggle btn-print" aria-expanded="true">พิมพ์</button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" x-placement="bottom-end" style="position: absolute; transform: translate3d(-56px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <a class="dropdown-item btn-print-items" data-type="label">ใบปะหน้ากล่อง</a>
                    <a class="dropdown-item btn-print-items" data-type="list">รายการแพ็คของ</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row row-cards row-deck">
    <div class="col-12">
        <div class="card">
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                    <tr>
                        <th class="w-1">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkbox-all">
                                <span class="custom-control-label"></span>
                        </label>
                        </th>
                        <th>เลขที่สั่งซื้อ</th>
                        <th>วันที่สั่งซื้อ</th>
                        <th>ช่องทาง</th>
                        <th>ผู้สั่งสินค้า</th>
                        <th>ยอดสุทธิ</th>
                        <th>สถานะ</th>
                        <th>เวลาโอน</th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade prompt-front" id="advancedSearchModal" tabindex="-1" role="dialog" aria-labelledby="advancedSearchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="advancedSearchModalLabel"><i class="fe fe-sliders"></i> ค้นหาขั้นสูง</h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">เลขที่สั่งซื้อ</label>
                        <input type="text" class="form-control" name="code-input">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">ผู้สั่งสินค้า</label>
                        <input type="text" class="form-control" name="customer-input">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">วันที่สั่งซื้อ</label>
                        <input type="text" class="form-control datepicker" name="create-at-input" placeholder="{{DATE('d/m/Y')}}">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-label">เวลาโอน</label>
                        <input type="text" class="form-control datepicker" name="transfered-at-input" placeholder="{{DATE('d/m/Y')}}">
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            <button type="button" class="btn btn-primary btn-advanced-search"><i class="fe fe-search"></i> ค้นหา</button>
        </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    var table;
    var $_status = 'draft';
    var $_paging = false;
    var $_showCheckbox = true;
    require(['jquery', 'datatables','datepicker','sweetAlert'], function($, datatable, datepicker, Swal) {
        $('.datepicker').datepicker({
            autoclose:true,
            format:'dd/mm/yyyy',
            language:'th',
            setDate: new Date()
        });

        $(function(){
            loadOverview();
        });
        function loadOverview () {
            $.ajax({
                url:"{{route('orders.overview')}}",
                method: "GET",
            }).done(function(data){
                $.each(data,function(status,val){
                    $(`.overview-text-${status}`).html(val);
                })
            }).fail(function( jqxhr, textStatus ) {
                Swal.fire({
                    type: 'error',
                    title: jqXHR.responseJSON.message
                });
            });
        }

        $dt = $('.table');
        tableSetting = {
            processing: true,
            serverSide: true,
            ajax:{
                url:"{!! route('orders.data') !!}",
                data: function (d) {
                    var code = $('input[name=code-input]').val();
                    var customer_name = $('input[name=customer-input]').val();
                    var created_at = $('input[name=create-at-input]').val();
                    var transfered_at = $('input[name=transfered-at-input]').val();
                    if(code){d.code=code}
                    if(customer_name){d.customer_name=customer_name}
                    if(created_at){d.created_at=created_at}
                    if(transfered_at){d.transfered_at=transfered_at}
                    d.scope = $_status;
                }
            },
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable: false },
                { data: 'code', name: 'code' },
                { data: 'created_at', name: 'created_at' },
                { data: 'sale_channel', name: 'sale_channel' },
                { data: 'shipping_full_name', name: 'shipping_full_name' },
                { data: 'net_total_amount', name: 'net_total_amount' },
                { data: 'status', name: 'status' },
                { data: 'transfered_at', name: 'transfered_at' },
            ],
            order:[[1,"desc"]],
            paging:$_paging,
            columnDefs : [
                {
                    targets: 0,
                    visible: $_showCheckbox,
                },
                {
                    targets: 3,
                    render: function (data, type, full, meta){
                        var icon = ``;
                        if(data == 'line'){
                            icon = `<span class="h1 text-orange"><i class="fab fa-line"></i></span>`;
                        }else if(data == 'facebook'){
                            icon = `<span class="h1 text-blue"><i class="fab fa-facebook-square"></i></span>`;
                        }else if(data == 'instagram'){
                            icon = `<span class="h1"><i class="fab fa-instagram-square"></i></span>`;
                        }else{
                            icon = `<span class="h1 text-info"><i class="fas fa-ellipsis-h"></i></span>`;
                        }
                        return icon;
                    }
                },
                {
                    targets: 5,
                    // className:'text-right',
                    render: function (data, type, full, meta){
                        return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                    }
                },
                {
                    targets: 6,
                    render: function (data, type, full, meta){
                        let status = {
                            'draft':'ร่าง',
                            'unpaid':'ยังไม่จ่าย',
                            'transfered':'โอนแล้ว',
                            'packing':'กำลังแพ็ค',
                            'paid':'เตรียมส่ง',
                            'shipped':'ส่งแล้ว',
                            'voided':'ยกเลิก'
                            
                        };
                        return status[data];
                    }
                }
            ],
            initComplete: function(){
                // $('.dataTables_filter').remove();
            },
            drawCallback: function (settings) {
                if (!$dt.parent().hasClass("table-responsive")) {
                    $dt.wrap("<div class='table-responsive text-nowrap'></div>");
                }
                loader.close();
            },
        };
        table = $dt.DataTable(tableSetting);

        $('.status').on('change',function(e){
            $_status = $(this).val();
            if($_status == 'shipped'){
                $_paging =true;
                $_showCheckbox = false;
            }else{
                $_paging =false;
                $_showCheckbox = true;
            }
            loader.init();
            $('#checkbox-all').prop('checked',false);
            $('.btn-change-status').text(`เปลี่ยนสถานะ`);
            $('.btn-print').text(`พิมพ์`);
            $dt.DataTable().destroy()
            tableSetting.paging = $_paging;
            // tableSetting.columnDefs[0].visible = $_showCheckbox;
            tableSetting.columnDefs[0].bVisible = $_showCheckbox;
            table = $dt.DataTable(tableSetting);

        });

        $('.btn-search').on('click',function(e){
            var text = $(this).parent().closest('.table-search').find('.text-search');
            loader.init();
            table.search(text.val()).draw();
        });
        $('.btn-advanced-search').on('click',function(e){
            table.draw();
            $('input[name=code-input]').val('');
            $('input[name=customer-input]').val('');
            $('input[name=create-at-input]').val('');
            $('input[name=transfered-at-input]').val('');
            $('#advancedSearchModal').modal('hide');
        });

        $('#checkbox-all').on('change',function(e){
            if($(this).prop('checked')){
                $('input[name=checkbox]').prop('checked',true);
            }else{
                $('input[name=checkbox]').prop('checked',false);
            }
            var quantity = $('input[name=checkbox]:checked').length;
            if(quantity > 0){
                $('.btn-change-status').text(`เปลี่ยนสถานะ (${quantity})`);
                $('.btn-print').text(`พิมพ์ (${quantity})`);
            }else{
                $('.btn-change-status').text(`เปลี่ยนสถานะ`);
                $('.btn-print').text(`พิมพ์`);
            }
        })

        $(document).on('change', '.checkbox-order',function(e){
            var quantity = $('input[name=checkbox]:checked').length;
            if(quantity > 0){
                $('.btn-change-status').text(`เปลี่ยนสถานะ (${quantity})`);
                $('.btn-print').text(`พิมพ์ (${quantity})`);
            }else{
                $('.btn-change-status').text(`เปลี่ยนสถานะ`);
                $('.btn-print').text(`พิมพ์`);
            }
        });

        $('.btn-change-status-items').on('click',function(e){
            let statusInfo = {
                            'draft':'ร่าง',
                            'unpaid':'ยังไม่จ่าย',
                            'transfered':'โอนแล้ว',
                            'packing':'กำลังแพ็ค',
                            'paid':'เตรียมส่ง',
                            'shipped':'ส่งแล้ว',
                            'voided':'ยกเลิก'
                            
                        };

            let currentStatus = $(this).parent().closest('.row-main').find('.status').val();
            let status = $(this).data('status');
            var orderIds = [];
            $('input[name=checkbox]').each(function(i,element){
                if($(element).prop('checked')){
                    orderIds.push($(element).val())
                }
            });
            Swal.fire({
                title: 'คุณแน่ใจใช่ไหม?',
                text:`เปลี่ยนสถานะออเดอร์จาก "${statusInfo[currentStatus]}" เป็นสถานะ "${statusInfo[status]}" จำนวน ${orderIds.length} ออเดอร์`,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน!',
                cancelButtonText: 'ยกเลิก'
              }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:"{{ route('orders.status') }}",
                        method:"POST",
                        dataType: "JSON",
                        data:{
                            _method:"PATCH",
                            _token: "{{ csrf_token() }}",
                            ids: orderIds,
                            status: status
                        },
                        beforeSend: function( xhr ) {
                            loader.init();
                        },
                    })
                    .done(function(data){
                        loader.close();
                        Swal.fire({
                            type: "success",
                            title: "บันทึกข้อมูลเรียบร้อย", 
                        });
                        loadOverview();
                        table.draw();
                    })
                    .fail(function(jqXHR, textStatus, $form) {
                        loader.close();
                        Swal.fire({
                            type: 'error',
                            title: jqXHR.responseJSON.message
                        });
                    });
                }
            });
        });

        $('.btn-print-items').on('click',function(e){
            let type = $(this).data('type');
            var orderIds = [];
            $('input[name=checkbox]').each(function(i,element){
                if($(element).prop('checked')){
                    orderIds.push($(element).val())
                }
            });
            if(orderIds.length === 0) return false;
            if(type == 'label'){
                window.open("{!! route('orders.print.label') !!}"+"?"+jQuery.param({orderIds}), '_newtab');
            }else{
                window.open("{!! route('orders.print.list') !!}"+"?"+jQuery.param({orderIds}), '_newtab');
            }
            
        });

    });

    require(['jquery', 'selectize'], function ($, selectize) {
        $('#select-beast').selectize({});
    });
  </script>
@endsection