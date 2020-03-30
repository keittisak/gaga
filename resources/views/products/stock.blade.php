@extends('layouts.main')
@section('title','Layouts')
@section('css')
    {{--  Css  --}}
@endsection
@section('content')
<div class="page-header">
    <h1 class="page-title prompt-front">
        คลังสินค้า
    </h1>
</div>
<div class="row prompt-front">
    <div class="col-12 px-0 mb-3">
        <div class="row gutters-xs">
            <div class="col-4">
                <input type="text" class="form-control" placeholder="ค้นหา ...">
            </div>
            <span class="col-auto">
                <button class="btn btn-secondary" type="button"><i class="fe fe-search"></i></button>
            </span>
            <span class="col">
                {{-- <a href="{{ route('products.create') }}" class="btn btn-primary float-right"><i class="fe fe-plus mr-2"></i> เพิ่มสินค้า</a> --}}
            </span>
        </div>
    </div>
</div>
<div class="row prompt-front">
    <div class="col-12 px-0">
        <div class="card">
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th>ชื่อสินค้า</th>
                            <th class="px-0 py-0">
                                <table class="text-nowrap w-100 text-center">
                                    <tr>
                                        <td class="w-20">SKU</td>
                                        <td class="w-20">ราคา</td>
                                        <td class="w-20">สต็อก</td>
                                        <td class="w-20">จอง</td>
                                        <td class="w-20">ส่งแล้ว</td>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>เสื้อคอกลม</td>
                            <td  class="px-0 py-0">
                                <table class="text-nowrap w-100 text-center">
                                    <tr>
                                        <td class="w-20">ไม่ระบุ</td>
                                        <td class="w-20">แดง</td>
                                        <td class="w-20">100</td>
                                        <td class="w-20">6</td>
                                        <td class="w-20">0</td>
                                    </tr>
                                    <tr>
                                        <td class="w-20">ไม่ระบุ</td>
                                        <td class="w-20">เขียว</td>
                                        <td class="w-20">100</td>
                                        <td class="w-20">6</td>
                                        <td class="w-20">0</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>เสื้อคอวี</td>
                            <td  class="px-0 py-0">
                                <table class="text-nowrap w-100 text-center">
                                    <tr>
                                        <td class="w-20">ไม่ระบุ</td>
                                        <td class="w-20">แดง</td>
                                        <td class="w-20">100</td>
                                        <td class="w-20">6</td>
                                        <td class="w-20">0</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    
</script>
@endsection