@extends('layouts.main')
@section('title','Stocks')
@section('css')
<style>
    .page{
        display:block;
    }
</style>
@endsection
@section('content')
<div class="row row-cards row-deck">
    <div class="col-md-6 col-xl-6">
        <div class="card card-collapsed">
            <div class="card-header">
                <h3 class="card-title">เพิ่มสินค้า</h3>
                <div class="card-options">
                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                </div>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label class="form-label">ชื่อสินค้า</label>
                                <input type="text" class="form-control" name="product_name">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">จำนวน</label>
                                <input type="number" class="form-control" name="quantity">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" class="btn btn-primary mr-2" id="submit-add-product">บันทึกข้อมูล</button>
                            <button type="button" class="btn btn-secondary">ยกเลิก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row row-cards row-deck">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Stocks</h3>
            </div>
            <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                <tr>
                    <th class="w-6">ชื่อสินค้า</th>
                    <th>จำนวน</th>
                    <th class="no-sort">การจัดการ</th>
                </tr>
                </thead>
            </table>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    var table
    require(['datatables', 'jquery'], function(datatable, $) {
            table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('stocks.data') !!}",
                columns: [
                    { data: 'product_name',name: 'product_name'},
                    { data: 'quantity', name: 'quantity' },
                    { data: 'id', name: 'id', orderable: false, searchable: false},
                ],
                columnDefs: [
                    {
                        targets : 2,
                        render: function ( data, type, full, meta ) {
                            return `
                                <button class="btn btn-secondary btn-sm mr-2 btn-action" onclick="buttonAction.action(${data},'minus')"><i class="fe fe-minus-circle"></i></button>
                                <button class="btn btn-secondary btn-sm mr-5 btn-action" onclick="buttonAction.action(${data},'plus')"><i class="fe fe-plus-circle"></i></button>
                                <button class="btn btn-danger btn-sm btn-action" onclick="buttonAction.delete(${data})"><i class="fa fa-close"></i></button>
                            `;
                        }
                    }
                ],
                initComplete :  function() {
                    $('.dataTables_filter').html(`<div class="input-group mb-3">
                                                    <input type="text" class="form-control" placeholder="Search something" aria-label="Search something" aria-describedby="basic-addon2">
                                                    <div class="input-group-append">
                                                    </div>
                                                </div>`);
                    const input = $('.dataTables_filter input').unbind();
                    self = this.api();
                    $searchButton = $('<button class="btn btn-primary btn-outline" type="button" id="datables-btn-search">')
                            .text('Search')
                            .click(function() {
                                    $('#datables-btn-search').attr("disabled", true);
                                    self.search(input.val()).draw();
                            })
                    $('.dataTables_filter .input-group-append').append($searchButton);
                },
                infoCallback : function( settings, start, end, max, total, pre ) {
                    $('#datables-btn-search').attr("disabled", false);
                    return `Showing ${start} to ${end} of ${total} entries`
                },
            });
        });
    
    require(['jquery'], function($){
        $('#submit-add-product').on('click', function(e){
            $(this).prop('disabled', true);
            var product_name = $('input[name=product_name]').val();
            var quantity = $('input[name=quantity]').val();
            if(product_name == "" || quantity == ""){
                alert('กรอกข้อมูลไม่ครบ!');
                return;
            }
            $.ajax({
                url: "{{ route('stocks.store') }}",
                method:'post',
                dataType:'json',
                data: {_token:'{{ Session::token() }}', product_name: product_name, quantity:quantity},
            })
            .done(function(data, textStatus, jqXHR) {
                table.ajax.reload();
                $('input[name=product_name]').val('');
                $('input[name=quantity]').val('');
                $(this).prop('disabled', false);
            })
            .fail(function(jqXHR, textStatus) {
                console.log(jqXHR)
                $(this).prop('disabled', false);
            })
        });

        buttonAction = {
            action:function(id,option){
                $('.btn-action').prop('disabled',true);
                var url = "{{route('stocks.update','_id')}}";
                var url = url.replace('_id', id);
                $.ajax({
                    url: url,
                    method:'post',
                    dataType:'json',
                    data: {_token:'{{ Session::token() }}', option:option},
                })
                .done(function(data, textStatus, jqXHR) {
                    table.ajax.reload();
                    $('.btn-action').prop('disabled',false);
                })
                .fail(function(jqXHR, textStatus) {
                    console.log(jqXHR)
                    $('.btn-action').prop('disabled',false);
                })
            },
            delete:function(id){
                $('.btn-action').prop('disabled',true);
                var url = "{{route('stocks.destroy','_id')}}";
                var url = url.replace('_id', id);
                $.ajax({
                    url: url,
                    method:'post',
                    dataType:'json',
                    data: {_token:'{{ Session::token() }}', _method:'delete'},
                })
                .done(function(data, textStatus, jqXHR) {
                    table.ajax.reload();
                    $('.btn-action').prop('disabled',false);
                })
                .fail(function(jqXHR, textStatus) {
                    console.log(jqXHR)
                    $('.btn-action').prop('disabled',false);
                })
            }
        }
    });



  </script>
@endsection