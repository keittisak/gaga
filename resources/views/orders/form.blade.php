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
                                <input type="text" class="form-control" placeholder="">
                                </div>
                                <span class="col-auto">
                                <button class="btn btn-secondary" type="button"><i class="fe fe-search"></i></button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">ชื่อผู้รับ</label>
                            <input type="text" class="form-control" name="example-text-input" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">ที่อยู่</label>
                            <textarea class="form-control" name="" id=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">ตำบล / อำเภอ / จังหวัด / รหัสไปรษณีย์</label>
                            <select name="beast" id="select-beast" class="form-control custom-select">
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
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label class="form-label">เสื้อคอกลม</label>
                                    <select name="" id="" class="form-control font-italic">
                                        <option value="">สีแดง - 370</option>
                                        <option value="">สีเขียว - 370</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 offset-md-3 offset-1 col-5">
                                <div class="form-group">
                                    <div class="row gutters-xs">
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm text-right mb-3" value="10000" readonly>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-prepend">
                                                    <button class="btn btn-outline-primary" type="button"><i class="fe fe-minus"></i></button>
                                                </span>
                                                <input type="text" class="form-control text-center" value="1">
                                                <span class="input-group-append">
                                                    <button class="btn btn-outline-primary" type="button"><i class="fe fe-plus"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label class="form-label">เสื้อคอกลม</label>
                                    <select name="" id="" class="form-control font-italic">
                                        <option value="">สีแดง - 370</option>
                                        <option value="">สีเขียว - 370</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 offset-md-3 offset-1 col-5">
                                <div class="form-group">
                                    <div class="row gutters-xs">
                                        <div class="col">
                                            <input type="text" class="form-control form-control-sm text-right mb-3" value="10000" readonly>
                                        </div>
                                        <div class="col-auto">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-prepend">
                                                    <button class="btn btn-outline-primary" type="button"><i class="fe fe-minus"></i></button>
                                                </span>
                                                <input type="text" class="form-control text-center" value="1">
                                                <span class="input-group-append">
                                                    <button class="btn btn-outline-primary" type="button"><i class="fe fe-plus"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="btn-list text-center">
                            <button type="button" class="btn btn-pill btn-outline-primary"><i class="fe fe-plus"></i></button>
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
                                            <input type="text" class="form-control text-right" value="10000" readonly>
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
                                            <input type="text" class="form-control text-right" value="0">
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
                                            <input type="text" class="form-control text-right" value="0">
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
                                            <input type="text" class="form-control text-right" value="10000" readonly>
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
                             <select class="form-control">
                                 <option>ธนาคารกสิกรไทย</option>
                             </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">เลขที่บัญชี</label>
                            <div class="form-control-plaintext">123456</div>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">วันที่โอน</label>
                            <input type="text" name="" id="" class="form-control" value="13/3/2020">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">เวลาโอน</label>
                            <input type="text" name="" id="" class="form-control" value="15:08">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">ยอดโอน</label>
                            <input type="text" name="" id="" class="form-control" value="1000">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<div class="btn-list text-center prompt-front">
    <button class="btn btn-pill btn-primary btn-lg">บันทึกคำสั่งซื้อ</button>
    <button class="btn btn-pill btn-secondary btn-lg">บันทึกคำสั่งซื้อและเพิ่ม</button>
</div>


@endsection
@section('js')
<script>
    require(['jquery', 'selectize'], function ($, selectize) {
        $(function(){
            $.ajax({
                url: '{{ asset("assets/json/subdistrict.json") }}',
                dataType: 'json',
            }).done(function( data ) {
                $('#select-beast').selectize({
                    valueField: 'name',
                    labelField: 'name',
                    searchField: 'name',
                    options: data,
                });
            });
        });
    });
</script>
@endsection