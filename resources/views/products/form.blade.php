@extends('layouts.main')
@section('title','Product Create')
@section('css')
    {{--  Css  --}}
@endsection
@section('content')
<div class="page-header">
    <h1 class="page-title prompt-front">
        เพิ่มสินค้า
    </h1>
</div>
<div class="row">
    <div class="col-md-8 col-12">
        <form class="card prompt-front" action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">ชื่อสินค้า</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
                <div class="form-group">
                    <label class="form-label">รายละเอียดสินค้า</label>
                    <textarea class="form-control" name="description" id="description" rows="6"></textarea>
                </div>
                <div class="form-group">
                    <div class="form-label">มีหลายแบบสินค้า</div>
                    <label class="custom-switch">
                    <input type="checkbox" name="type" id="type" class="custom-switch-input">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">ปิด</span>
                    </label>
                </div>
                <div class="product-variable" style="display:none">
                    <div class="form-group" id="product-variable-1">
                        <label class="form-label">วิธีการแบ่งแบบสินค้า 1</label>
                        <fieldset class="form-fieldset">
                            <div class="row">
                                <div class="col-md-3 col-4">
                                    <label class="form-label text-right">ระบุตัวเลือก</label>
                                </div>
                                <div class="col-md-6 col-8 product-variable-optoin-input">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="variants[1][options][]">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 offset-md-3 offset-4 col-8">
                                    <button type="button" class="btn btn-outline-info btn-block btn-add-product-variable-optoin" data-variable="1">เพิ่มตัวเลือก</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group" id="product-variable-2">
                        <label class="form-label">วิธีการแบ่งแบบสินค้า 2 <button type="button" class="btn btn-outline-info btn-block" id="btn-add-product-variable-2">เพิ่มวิธีแบ่งแบบสินค้า</button></label>
                        <fieldset class="form-fieldset" style="display:none">
                            <div class="row">
                                <div class="col-md-3 col-4">
                                    <label class="form-label text-right">ระบุตัวเลือก</label>
                                </div>
                                <div class="col-md-6 col-8 product-variable-optoin-input">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="variants[2][options][]">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 offset-md-3 offset-4 col-8">
                                    <button type="button" class="btn btn-outline-info btn-block btn-add-product-variable-optoin" data-variable="2">เพิ่มตัวเลือก</button>
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
                                <button type="button" class="btn btn-primary btn-block">ปรับปรุงแบบสินค้าทั้งหมด</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">รายการแบบสินค้า</label>
                        <div class="table-responsive">
                            <table class="table text-nowrap card-table" style="min-width: 650px">
                                <thead>
                                    <tr>
                                        <th><small>เลือก</small></th>
                                        <th class="w-25"><small>ชื่อแบบสินค้า</small></th>
                                        <th><small>รหัสสินค้า</small></th>
                                        <th><small>ราคา</small></th>
                                        <th><small>ราเต็ม</small></th>
                                        <th><small>ต้นทุน</small></th>
                                        <th><small>น้ำหนัก (กก.)</small></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                                <span class="custom-control-label"></span>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                 </div>

                <div class="product-simple">
                    <div class="form-group">
                        <label class="form-label">ราคาสินค้า</label>
                        <div class="col-md-4 col-12 pl-0">
                            <input type="text" class="form-control" name="price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ราคาเต็ม</label>
                        <div class="col-md-4 col-12 pl-0">
                            <input type="text" class="form-control" name="full_price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ต้นทุน</label>
                        <div class="col-md-4 col-12 pl-0">
                            <input type="text" class="form-control" name="cost">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">น้ำหนัก (กก.)</label>
                        <div class="col-md-4 col-12 pl-0">
                            <input type="text" class="form-control" name="call_unit">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-pill btn-danger float-left">ยกเลิก</button>
                <button type="submit" class="btn btn-pill btn-primary float-right">บันทึก</button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('js')
<script>
    require(['jqueryForm','jquery'], function(form,$) {
        $('#type').on('change', function(e){
            if($(this).prop('checked')){
                $('.custom-switch-description').text('เปิด');
                $('.product-variable').show();
                $('.product-simple').hide();
            }else{
                $('.custom-switch-description').text('ปิด');
                $('.product-variable').hide();
                $('.product-simple').show();
            }
        });

        $('.btn-add-product-variable-optoin').on('click',function(e){
            var variable = $(this).data('variable');
            var element = `<div class="form-group">
                                <input type="text" class="form-control" name="variants[${variable}][options][]">
                            </div>`;
            var input = $(this).parents('.form-fieldset').find('.product-variable-optoin-input');
            input.append(element);
        });

        $('#btn-add-product-variable-2').on('click',function(e){
            $(this).parents('.form-group').find('.form-fieldset').show();
            $(this).hide();
        });

        $('form').ajaxForm({
            dataType: 'json',
            beforeSubmit: function (arr, $form, options) {

                // $('body').append('<div class="preloader"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>');
            },
            success: function (res) {
                // Swal.fire({
                //     type: "success",
                //     title: "บันทึกข้อมูลสินค้าเรียบร้อย", 
                // }).then(function(){
                //     window.location.replace('{{ route('products.index') }}');
                // });
            },
            error: function (jqXHR, status, options, $form) {
                // $('.preloader').remove();
                // Toast.fire({
                //     type: 'error',
                //     title: jqXHR.responseJSON.message
                // });
                // if(jqXHR.status === 422){
                //     errorManage.validate(jqXHR.responseJSON.errors, $('#form-content'));
                // }
            }
        });
    });
</script>
@endsection