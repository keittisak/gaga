@extends('layouts.main')
@section('title','Layouts')
@section('css')
    {{--  Css  --}}
@endsection
@section('content')
<div class="page-header">
    <h1 class="page-title prompt-front">
        เพิ่มคำสั่งซื้อ
    </h1>
</div>
<form id="form" action="{{route('orders.store')}}" method="POST">
@csrf
<div class="row row-cards row-deck prompt-front">
    <div class="col-12 px-0">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">การจัดส่ง</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 offset-md-3 col-12">
                        <div class="form-group">
                            <label class="form-label">หมายเลขโทรศัพท์</label>
                            <div class="row gutters-xs">
                                <div class="col">
                                <input type="text" class="form-control" placeholder="" name="phone" id="phone">
                                </div>
                                <span class="col-auto">
                                <button class="btn btn-secondary" type="button"><i class="fe fe-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">ชื่อผู้รับ</label>
                            <input type="hidden" readonly name="customer_id">
                            <input type="text" class="form-control" placeholder="" name="shipping_name" id="shipping_name">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">ที่อยู่</label>
                            <textarea class="form-control" name="shipping_address" id="shipping_address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">ตำบล / อำเภอ / จังหวัด / รหัสไปรษณีย์</label>
                            <input type="hidden" readonly name="shipping_subdistrict_id" value="">
                            <input type="hidden" readonly name="shipping_subdistrict_text" value="">
                            <select name="shipping_subdistrict" id="shipping_subdistrict" class="form-control custom-select">
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="row row-cards row-deck prompt-front">
    <div class="col-12 px-0">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">รายการสินค้า</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 offset-md-3 col-12">
                        <div class="detail-display">
                        </div>
                        <div class="btn-list text-center">
                            <button type="button" class="btn btn-pill btn-outline-primary" data-toggle="modal" data-target="#product-modal"><i class="fe fe-plus"></i></button>
                          </div>
                    </div>
                </div>
                
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6 offset-md-3 col-12">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <label for="">ราคาสินค้า</label>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <div class="row gutters-xs">
                                        <div class="col">
                                            <input type="text" class="form-control text-right" name="total_amount" id="total_amount" value="0" readonly>
                                        </div>
                                        <span class="col-auto">
                                            บาท
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <label for="">ค่าจัดส่ง</label>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <div class="row gutters-xs">
                                        <div class="col">
                                            <input type="text" class="form-control text-right" name="shipping_fee" id="shipping_fee" value="0">
                                        </div>
                                        <span class="col-auto">
                                            บาท
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <label for="">ส่วนลด</label>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <div class="row gutters-xs">
                                        <div class="col">
                                            <input type="text" class="form-control text-right" name="discount_amount" id="discount_amount" value="0">
                                        </div>
                                        <span class="col-auto">
                                            บาท
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <label for="">ยอดสุทธิ</label>
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <div class="row gutters-xs">
                                        <div class="col">
                                            <input type="text" class="form-control text-right" name="net_total_amount" id="net_total_amount" value="" readonly>
                                        </div>
                                        <span class="col-auto">
                                            บาท
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row row-cards row-deck prompt-front">
    <div class="col-12 px-0">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">การชำระเงิน</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 offset-md-3 col-12">
                        <div class="form-group">
                            <label for="" class="form-label">โอนเข้าบัญชี</label>
                             <select class="form-control" name="transfere[bank_id]" id="bank_id_transfere">
                                 <option>ธนาคารกสิกรไทย</option>
                             </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">เลขที่บัญชี</label>
                            <div class="form-control-plaintext">123456</div>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">วันที่โอน</label>
                            <input type="text" name="transfere[date]" id="date_transfere" class="form-control" value="13/3/2020">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">เวลาโอน</label>
                            <input type="text" name="transfere[time]" id="time_transfere" class="form-control" data-mask="00:00" data-mask-clearifnotmatch="true" placeholder="00:00" autocomplete="off" maxlength="5">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">ยอดโอน</label>
                            <input type="text" name="transfere[amount]" id="amount_transfere" class="form-control" value="">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="btn-list text-center prompt-front">
    <button type="button" class="btn btn-pill btn-primary btn-lg btn-save">บันทึกคำสั่งซื้อ</button>
    <button class="btn btn-pill btn-secondary btn-lg">บันทึกคำสั่งซื้อและเพิ่ม</button>
</div>
</form>
<div class="modal fade prompt-front" id="product-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เลือกสินค้า</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover card-table" id="product-table" style="cursor:pointer">
                    {{-- <thead>
                        <tr>
                            <th>สินค้า</th>
                            <th>ราคา</th>
                        </tr>
                    </thead> --}}
                    <tbody>
                        @foreach($products as $item)
                        <tr data-product="{{json_encode($item)}}">
                            <td>{{$item->name}}</td>
                            <td class="text-right">
                                <span class="badge badge-default">{{number_format($item->skus[0]->price,2)}}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    require(['jquery', 'selectize', 'datatables'], function ($, selectize, $datatable) {
        $(function(){
            $.ajax({
                url: '{{ asset("assets/json/subdistrict.json") }}',
                dataType: 'json',
                success: function(data) {
                    $('#shipping_subdistrict').append('<option value=""></option>');
                    for (var i in data) {
                        $('#shipping_subdistrict').append('<option value="' + i + '">' + data[i].name + '</option>');
                    }
                }
            }).done(function( data ) {
                $('#shipping_subdistrict').selectize({
                    onChange:function(val){
                        var data = this.options[val];
                        $('input[name=shipping_subdistrict_id]').val(val);
                        $('input[name=shipping_subdistrict_text]').val(data.text);
                    }
                });
            });
        });

        $('.btn-save').on('click',function(e){
            $('#form').submit();
            var data = $('#form').serializeArray();
            console.log(data);
        })

        $('#product-table tr').on('click', function(e){
            var product = $(this).data('product');
            console.log(product);
            var skus = product.skus;
            var element = ``;
            var select_sku = ``;
            var display_none = ``;
            var index = $('.detail_products').length;
            index+=1;

            if(product.type == 'simple'){
                display_none = 'd-none'
            }
            select_sku += `<select name="details[${index}][sku]" id="" class="form-control font-italic ${display_none}">`;
            for(i = 0; i < skus.length; i++)
            {
                select_sku += `<option value="${skus[i].sku}">${skus[i].name} - ${skus[i].price}</option>`
            }
            select_sku += `</select>`;

            element += `<div class="row detail_products">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label class="form-label">${product.name}</label>
                                    <input type="hidden" name="details[${index}][product_id]" value="${product.id}">
                                    <input type="hidden" name="details[${index}][product_name]" value="${product.name}">
                                    ${select_sku}
                                </div>
                            </div>
                            <div class="col-md-3 offset-md-3 offset-1 col-5">
                                <div class="form-group">
                                    <div class="row gutters-xs">
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm text-right mb-3 detail-total-amount" name="details[${index}][total_amount]" value="${product.skus[0].price}" readonly>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-prepend">
                                                    <button class="btn btn-outline-primary btn-minus" type="button" data-price="${product.skus[0].price}"><i class="fe fe-minus"></i></button>
                                                </span>
                                                <input type="text" class="form-control text-center detail-quantity" name="details[${index}][quantity]" value="1">
                                                <span class="input-group-append">
                                                    <button class="btn btn-outline-primary btn-plus" type="button" data-price="${product.skus[0].price}"><i class="fe fe-plus"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>`;
            $('.detail-display').append(element);
            updateTotalAmount();
            $('#product-modal').modal('hide');
        });
        
        $(document).on('click', '.btn-minus',function(e){
            var total_amount = $(this).closest('.form-group').find('.detail-total-amount');
            var quantity = $(this).closest('.form-group').find('.detail-quantity');
            var price = $(this).data('price');
            if($(quantity).val() > 1)
            {
                $(quantity).val(parseInt($(quantity).val())-1);
            }
            $(total_amount).val(parseInt(price)*parseInt($(quantity).val()));
            updateTotalAmount();
            
        });

        $(document).on('click', '.btn-plus',function(e){
            var total_amount = $(this).closest('.form-group').find('.detail-total-amount');
            var quantity = $(this).closest('.form-group').find('.detail-quantity');
            var price = $(this).data('price');
            $(quantity).val(parseInt($(quantity).val())+1);
            $(total_amount).val(parseInt(price)*parseInt($(quantity).val()));
            updateTotalAmount();

        });

        $('input[name=shipping_fee]').on('keyup',function(e){
            updateNetTotalAmount();
        });

        $('input[name=discount_amount]').on('keyup',function(e){
            updateNetTotalAmount();
        });

        function updateTotalAmount ()
        {
            var total_amount = 0;
            $('.detail-total-amount').each(function(index,el){
                total_amount += parseInt($(el).val());
            })
            $('input[name=total_amount]').val(total_amount);
            updateNetTotalAmount();
        }

        function updateNetTotalAmount ()
        {
            var total_amount = parseInt($('input[name=total_amount]').val());
            var shipping_fee = parseInt($('input[name=shipping_fee]').val());
            var discount_amount = parseInt($('input[name=discount_amount]').val());
            var net_total_amount = (total_amount + shipping_fee) - discount_amount;
            $('input[name=net_total_amount]').val(net_total_amount);
        }
    });
    
</script>
@endsection