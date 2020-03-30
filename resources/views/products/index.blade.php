@extends('layouts.main')
@section('title','Layouts')
@section('css')
    {{--  Css  --}}
@endsection
@section('content')
<div class="page-header">
    <h1 class="page-title prompt-front">
        สินค้า
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
                <a href="{{ route('products.create') }}" class="btn btn-primary float-right"><i class="fe fe-plus mr-2"></i> เพิ่มสินค้า</a>
            </span>
        </div>
    </div>
</div>
<div class="row prompt-front">
    <div class="col-12 px-0">
        <div class="card">
            <div class="table-responsive">
                <table class="table card-table table-vcenter table-striped text-nowrap">
                    <thead>
                        <th class="w-1">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                <span class="custom-control-label"></span>
                            </label>
                        </th>
                        <th>ชื่อสินค้า</th>
                        <th>ราคา</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                    <span class="custom-control-label"></span>
                                </label>
                            </td>
                            <td>เสื้อคอกลม</td>
                            <td>370.00</td>
                        </tr>
                        <tr>
                            <td>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="example-checkbox2" value="option2">
                                    <span class="custom-control-label"></span>
                                </label>
                            </td>
                            <td>เสื้อคอวี</td>
                            <td>370.00</td>
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