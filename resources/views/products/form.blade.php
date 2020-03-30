@extends('layouts.main')
@section('title','Layouts')
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
        <form class="card prompt-front">
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">ชื่อสินค้า</label>
                    <input type="text" class="form-control" name="example-text-input">
                </div>
                <div class="form-group">
                    <label class="form-label">รายละเอียดสินค้า</label>
                    <textarea class="form-control" name="example-textarea-input" rows="6"></textarea>
                </div>
                <div class="form-group">
                    <div class="form-label">มีหลายแบบสินค้า</div>
                    <label class="custom-switch">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">ปิด</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">วิธีการแบ่งแบบสินค้า 1</label>
                    <fieldset class="form-fieldset">
                        <div class="row">
                            <div class="col-md-3 col-4">
                                <label class="form-label text-right">ระบุตัวเลือก</label>
                            </div>
                            <div class="col-md-6 col-8">
                                <div class="form-group">
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-info btn-block">เพิ่มตัวเลือก</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="form-group">
                    <label class="form-label">วิธีการแบ่งแบบสินค้า 2</label>
                    <fieldset class="form-fieldset">
                        <div class="row">
                            <div class="col-md-3 col-4">
                                <label class="form-label text-right">ระบุตัวเลือก</label>
                            </div>
                            <div class="col-md-6 col-8">
                                <div class="form-group">
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-info btn-block">เพิ่มตัวเลือก</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="form-group">
                    <label class="form-label">ปรับปรุงทั้งหมด</label>
                    <div class="row gutters-xs">
                    <div class="col-4">
                        <input type="text" class="form-control" name="example-text-input" placeholder="ราคาสินค้า">
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="example-text-input" placeholder="ราคาเต็ม">
                    </div>
                    <div class="col-4">
                        <input type="text" class="form-control" name="example-text-input" placeholder="น้ำหนัก (กก.)">
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



                <div class="form-group">
                    <label class="form-label">ราคาสินค้า</label>
                    <div class="col-md-4 col-12 pl-0">
                        <input type="text" class="form-control" name="example-text-input">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">ราคาเต็ม</label>
                    <div class="col-md-4 col-12 pl-0">
                        <input type="text" class="form-control" name="example-text-input">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">น้ำหนัก (กก.)</label>
                    <div class="col-md-4 col-12 pl-0">
                        <input type="text" class="form-control" name="example-text-input">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-pill btn-danger float-left">ยกเลิก</button>
                <button class="btn btn-pill btn-primary float-right">บันทึก</button>
            </div>
        </form>
    </div>
</div>

@endsection
@section('js')
<script>
    
</script>
@endsection