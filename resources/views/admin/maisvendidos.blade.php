@extends('layouts.app', ['page' => __('Tables'), 'pageSlug' => 'tables'])

@section('content')
<div class="row">
    <div class="col-md-12">
            <div class="card ">
            <div class="card-header">
                <h4 class="card-title"> Simple Table</h4>
            </div>
            <div class="card-body">
                    <div class="table-responsive">
                        <table class="table compact table-striped table-bordered table-hover" id="datatable" style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th data-sortable="true" width="100px">Código</th>
                                    <th data-sortable="true" width="250px">Descrição</th>
                                    <th data-sortable="true" width="80px">Qtd Atual</th>
                                    <th data-sortable="true" width="80px">Qtd Estoque</th>
                                    <th data-sortable="true" width="80px">Qtd Vendida Mês</th>
                                    <th data-sortable="true" width="80px">Valor Total Mês</th>
                                    <th data-sortable="true" width="80px">Qtd Média 3 Meses</th>
                                    <th data-sortable="true" width="80px">Média 3 Meses</th>
                                    <th data-sortable="true" width="80px">Falta Comprar</th>
                                </tr>
                            </thead>
                            <tbody class="text-center"></tbody>
                        </table>
                    </div>
            </div>
            </div>
    </div>
</div>
@endsection

@push("js")

    <script src="{{URL::asset('assets/jquery/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/jquery/jquery.validate.min.js')}}"></script>
    <script src="{{URL::asset('assets/moment/moment.js')}}"></script>
    <script src="{{URL::asset('assets/bootstrap/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{URL::asset('assets/bootstrap/js/bootstrap-datepicker.pt-BR.min.js')}}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{URL::asset('assets/bootstrap/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('js/produto_mais_vendidos.js')}}"></script>

@endpush
@push("styles")
    <link rel="stylesheet"  type="text/css" href="{{URL::asset('assets/bootstrap/css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet"  type="text/css" href="{{URL::asset('assets/datatables/dataTableRender.css')}}">
    <link rel="stylesheet"  type="text/css" href="{{URL::asset('assets/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.css')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

@endpush
