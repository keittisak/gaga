@extends('layouts.main')
@section('title',$title_en)
@section('css')
    {{--  Css  --}}
@endsection
@section('content')
<div class="page-header">
    <h1 class="page-title prompt-front">
        {{$title_th}}
    </h1>
</div>
<div class="row">
    <div class="col-md-8 col-12">
        <form class="card prompt-front" action="{{ ($action == 'create')?route('products.store'):route('products.update',$product->id)}}" method="POST">
            @csrf
            @if($action == 'update')<input type="hidden" name="_method" value="PUT">@endif
            <div class="card-body">
                <div class="dimmer">
                <div class="loader"></div>
                <div class="dimmer-content">
                <div class="form-group">
                    <label class="form-label">ชื่อสินค้า <span class="form-required">*</span></label>
                <input type="text" class="form-control" name="name" id="name" value="{{$product->name}}">
                </div>
                <div class="form-group">
                    <label class="form-label">รายละเอียดสินค้า</label>
                <textarea class="form-control" name="description" id="description" rows="6">{{$product->description}}</textarea>
                </div>
                <div class="form-group">
                    <div class="row">
                    <div class="col-6">
                        <div class="form-label">มีหลายแบบสินค้า</div>
                        <label class="custom-switch">
                        <input type="checkbox" name="type" id="type" class="custom-switch-input" @if($product->type == 'variable') checked @endif>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">ปิด</span>
                        </label>
                    </div>
                    <div class="col-6" >
                        <button type="button" class="btn btn-link float-right" id="btn-clear-variant" @if($action == 'create' || $product->type == 'simple') style="display:none"  @endif><i class="far fa-trash-alt"></i> ล้างทิ้ง</button>
                    </div>
                    </div>
                </div>
                <div class="product-variable" @if(empty($product->type) || $product->type == 'simple') style="display:none" @endif>
                    <div class="form-group" id="product-variable-1" @if($action == 'update')style="display:none"@endif>
                        <label class="form-label">วิธีการแบ่งแบบสินค้า 1</label>
                        <fieldset class="form-fieldset">
                            <div class="row">
                                <div class="col-md-3 col-4">
                                    <label class="form-label text-right">ระบุตัวเลือก</label>
                                </div>
                                <div class="col-md-6 col-8 product-variable-optoin-input">
                                {{-- @if(isset($variants[0]))
                                <input type="hidden" class="form-control" name="variants[0][id]" value="{{$variants[0]->id}}">
                                <input type="hidden" class="form-control" name="variants[0][name]" value="variant-1">
                                    @foreach($variants[0]->options as $key => $option)
                                    <div class="form-group">
                                        <input type="text" class="form-control input-option" name="variants[0][options][{{$key}}][name]" value="{{$option->name}}">
                                        <input type="hidden" class="form-control" name="variants[0][options][{{$key}}][id]" value="{{$option->id}}">
                                    </div>
                                    @endforeach
                                @else
                                    <div class="form-group">
                                        <input type="text" class="form-control input-option" name="variants[0][options][][name]" >
                                    </div>
                                
                                @endif --}}
                        
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 offset-md-3 offset-4 col-8">
                                    <button type="button" class="btn btn-outline-info btn-block btn-add-product-variable-optoin" data-variable="1"><i class="fas fa-plus"></i> เพิ่มตัวเลือก</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group" id="product-variable-2" @if($action == 'update')style="display:none"@endif>
                        <label class="form-label">วิธีการแบ่งแบบสินค้า 2 <button type="button" class="btn btn-outline-info btn-block" id="btn-add-product-variable-2" @if(isset($variants[1])) style="display:none" @endif>เพิ่มวิธีแบ่งแบบสินค้า</button></label>
                        <fieldset class="form-fieldset" @if(!isset($variants[1])) style="display:none" @endif>
                            <div class="row">
                                <div class="col-md-3 col-4">
                                    <label class="form-label text-right">ระบุตัวเลือก</label>
                                </div>
                                <div class="col-md-6 col-8 product-variable-optoin-input">
                                    {{-- @if(isset($variants[1]))
                                    <input type="hidden" class="form-control" name="variants[1][id]" value="{{$variants[1]->id}}">
                                    <input type="hidden" class="form-control" name="variants[1][name]" value="variant-1">
                                    @foreach($variants[1]->options as $key => $option)
                                    <div class="form-group">
                                        <input type="text" class="form-control input-option" name="variants[1][options][{{$key}}][name]" value="{{$option->name}}">
                                        <input type="hidden" class="form-control" name="variants[1][options][{{$key}}][id]" value="{{$option->id}}">
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="form-group">
                                        <input type="text" class="form-control input-option" name="variants[1][options][][name]">
                                    </div>
                                    @endif --}}
                        
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 offset-md-3 offset-4 col-8">
                                    <button type="button" class="btn btn-outline-info btn-block btn-add-product-variable-optoin" data-variable="2"><i class="fas fa-plus"></i> เพิ่มตัวเลือก</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ปรับปรุงทั้งหมด</label>
                        <div class="row gutters-xs">
                            <div class="col-4">
                                <input type="text" class="form-control" id="set-all-variable-price" placeholder="ราคาสินค้า">
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" id="set-all-variable-full_price" placeholder="ราคาเต็ม">
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" id="set-all-variable-cost"  placeholder="ต้นทุน">
                            </div>
                        </div>
                        <div class="row gutters-xs mt-2">
                            <div class="col-4">
                                <input type="text" class="form-control" id="set-all-variable-call_unit"  placeholder="น้ำหนัก (กก.)">
                            </div>
                            <div class="col-8">
                                <button type="button" class="btn btn-primary btn-block" id="set-all-variable">ปรับปรุงแบบสินค้าทั้งหมด</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">รายการแบบสินค้า</label>
                        <div class="table-responsive">
                            <table class="table text-nowrap card-table" style="min-width: 650px" id="table-product-skus">
                                <thead>
                                    <tr>
                                        <th><small>เลือก</small></th>
                                        <th class="w-25"><small>ชื่อแบบสินค้า</small></th>
                                        {{-- <th><small>รหัสสินค้า</small></th> --}}
                                        <th><small>ราคา</small></th>
                                        <th><small>ราเต็ม</small></th>
                                        <th><small>ต้นทุน</small></th>
                                        <th class="w-1"><small>น้ำหนัก (กก.)</small></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($product->skus)
                                        @foreach ($product->skus as $key => $item)
                                        <tr>
                                            <td class="">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="skus[{{$key}}][active]" value="1" @if($item->status =='active') checked @endif>
                                                    <span class="custom-control-label"></span>
                                            </label></td>
                                            <td>
                                                <input type="hidden" class="form-control" name="skus[{{$key}}][id]" value="{{$item->id}}">
                                                <input type="text" class="form-control" name="skus[{{$key}}][name]" value="{{$item->name}}">
                                            </td>
                                            
                                            <td>
                                                <input type="text" class="form-control variable-price" name="skus[{{$key}}][price]" value="{{$item->price}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control variable-full_price" name="skus[{{$key}}][full_price]" value="{{$item->full_price}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control variable-cost" name="skus[{{$key}}][cost]" value="{{$item->cost}}">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control variable-call_unit" name="skus[{{$key}}][call_unit]" value="{{$item->call_unit}}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn  btn-sm btn-delete-sku" ><i class="fas fa-times"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                @if($action != 'create')
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-center pb-0"><button type="button" class="btn btn-primary btn-add-sku">เพิ่มแบบสินค้า</button></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                 </div>

                <div class="product-simple" @if($product->type == 'variable') style="display:none" @endif>
                    <div class="form-group">
                        <label class="form-label">ราคาสินค้า <span class="form-required">*</span></label>
                        <div class="col-md-4 col-12 pl-0">
                            <input type="hidden" class="form-control" name="sku_id" value="{{isset($product->skus[0])?$product->skus[0]->id:''}}">
                            <input type="text" class="form-control" name="price" value="{{isset($product->skus[0])?$product->skus[0]->price:''}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ราคาเต็ม <span class="form-required">*</span></label>
                        <div class="col-md-4 col-12 pl-0">
                            <input type="text" class="form-control" name="full_price" value="{{isset($product->skus[0])?$product->skus[0]->full_price:''}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ต้นทุน <span class="form-required">*</span></label>
                        <div class="col-md-4 col-12 pl-0">
                            <input type="text" class="form-control" name="cost" value="{{isset($product->skus[0])?$product->skus[0]->cost:''}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">น้ำหนัก (กก.)</label>
                        <div class="col-md-4 col-12 pl-0">
                            <input type="text" class="form-control" name="call_unit" value="{{isset($product->skus[0])?$product->skus[0]->call_unit:''}}">
                        </div>
                    </div>
                </div>
                </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('products.index') }}" class="btn btn-pill btn-danger float-left">ยกเลิก</a>
                <button type="submit" class="btn btn-pill btn-primary float-right">บันทึก</button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('js')
<script>
    require(['sweetAlert','jqueryForm','jquery'], function(Swal,form,$) {
        $('#type').on('change', function(e){
            if($(this).prop('checked')){
                $('.custom-switch-description').text('เปิด');
                $('.product-variable').show();
                $('.product-simple').hide();
                $('#product-variable-1').show();
                $('#product-variable-2').show();
                $('#btn-clear-variant').show();
    
                var tr = $('#table-product-skus').find('tbody tr');
                if(tr.length){
                    $('#product-variable-1').hide();
                    $('#product-variable-2').hide();
                }else{
                    $('#product-variable-1').show();
                    $('#product-variable-2').show();
                }
                    
      
            }else{
                $('.custom-switch-description').text('ปิด');
                $('.product-variable').hide();
                $('.product-simple').show();
                $('#btn-clear-variant').hide();
            }

        });
        $('#btn-clear-variant').on('click',function(e){
            $('#table-product-skus').find('tbody').html('');
            $('#type').prop('checked',false).change();
        });

        $('.btn-add-product-variable-optoin').on('click',function(e){
            var variable = $(this).data('variable');
            var element = `<div class="form-group">
                                <input type="text" class="form-control input-option" name="variants[${variable}][options][][name]">
                            </div>`;
            var input = $(this).parents('.form-fieldset').find('.product-variable-optoin-input');
            input.append(element);
        });

        $('#btn-add-product-variable-2').on('click',function(e){
            $(this).parents('.form-group').find('.form-fieldset').show();
            $(this).hide();
        });

        $(document).on('keyup','.input-option',function(e){
            
            if($(this).val() !== ''){
                var variants = [];
                $('.product-variable-optoin-input').each(function(variant_key,options){
                    variants[variant_key] = [];
                    $(options).find('.input-option').each(function(option_key,input){
                        if($(input).val() !== ""){
                            variants[variant_key][option_key] = $(input).val();
                        }
                    });
                });
                var products_stamp = [];
                var products = []
                var skus = [];
                for($i = 0; $i < variants[0].length; $i++)
                {
                    if(variants[1] !== undefined && variants[1].length > 0)
                    {
                        for($j = 0; $j < variants[1].length; $j++)
                        {
                            skus.push([$i,$j])
                        }
                    }else{
                        skus.push([$i])
                    }
                    
                }
                var element_option_sku = ``;
                for(i = 0; i < skus.length; i++)
                {
                    var option_str = ``;
                    for(n = 0; n < skus[i].length; n++)
                    {
                        option_str += `${variants[n][skus[i][n]]} `;
                    }
                    
                    element_option_sku += `<tr>
                                        <td class="">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="skus[${i}][active]" value="1" checked>
                                                <span class="custom-control-label"></span>
                                        </label></td>
                                        <td>
                                            <input type="text" class="form-control" name="skus[${i}][name]" value="${option_str}">
                                        </td>
                                        
                                        <td>
                                            <input type="text" class="form-control variable-price" name="skus[${i}][price]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control variable-full_price" name="skus[${i}][full_price]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control variable-cost" name="skus[${i}][cost]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control variable-call_unit" name="skus[${i}][call_unit]">
                                        </td>
                                    </tr>`
                }
                $('#table-product-skus tbody').html(`${element_option_sku}`);
            }
    });

    $('#set-all-variable').click(function(e){
        var price = $('#set-all-variable-price').val();
        var full_price = $('#set-all-variable-full_price').val();
        var call_unit = $('#set-all-variable-call_unit').val();
        var cost = $('#set-all-variable-cost').val();
        if(price){$('#table-product-skus tbody').find('.variable-price').val(price)}
        if(full_price){$('#table-product-skus tbody').find('.variable-full_price').val(full_price)}
        if(call_unit){$('#table-product-skus tbody').find('.variable-call_unit').val(call_unit)}
        if(cost){$('#table-product-skus tbody').find('.variable-cost').val(cost)}
    });

    $(document).on('click', '.btn-delete-sku',function(e){
        $(this).closest('tr').remove();
    });

    $('.btn-add-sku').on('click',function(e){
        var tr = $('#table-product-skus tbody tr');
        var i = tr.length +1;
        var element_option_sku = ``;
        element_option_sku += `<tr>
                                        <td class="">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="skus[${i}][active]" value="1" checked>
                                                <span class="custom-control-label"></span>
                                        </label></td>
                                        <td>
                                            <input type="text" class="form-control" name="skus[${i}][name]" value="">
                                        </td>
                                        
                                        <td>
                                            <input type="text" class="form-control variable-price" name="skus[${i}][price]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control variable-full_price" name="skus[${i}][full_price]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control variable-cost" name="skus[${i}][cost]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control variable-call_unit" name="skus[${i}][call_unit]">
                                        </td>
                                        <td>
                                            <button type="button" class="btn  btn-sm btn-delete-sku" ><i class="fas fa-times"></i></button>
                                        </td>
                                    </tr>`
        $('#table-product-skus tbody').append(`${element_option_sku}`);
    });

        $('form').ajaxForm({
            dataType: 'json',
            beforeSubmit: function (arr, $form, options) {
                loader.init();
            },
            success: function (res) {
                loader.close();
                Swal.fire({
                    type: "success",
                    title: "บันทึกข้อมูลเรียบร้อย", 
                }).then(function(){
                    @if($action != "update")
                    window.location.replace('{{ route('products.index') }}');
                    @endif
                });
                
            },
            error: function (jqXHR, status, options, $form) {
                // $('.card-body').find('.dimmer').removeClass('active');
                // $('button[type=submit]').prop('disabled',false);
                loader.close();
                if(jqXHR.status === 422){
                    Swal.fire({
                        type: 'error',
                        title: 'ระบุข้อมูลไม่ถูกต้อง'
                    });
                }else{
                    Swal.fire({
                        type: 'error',
                        title: jqXHR.responseJSON.message
                    });
                }
                
            }
        });
    });
</script>
@endsection