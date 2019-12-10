@extends('layouts.app')

@section('content')
<div class="content">
        <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <a href="{{url("doctor/create")}}" class="btn btn-info"><i class="fas fa-plus"></i> Adicionar</a>
            </div>
            <h4 class="page-title">Profissionais</h4>
        </div>
    </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title">Usuários</h4> --}}
                        
                        <div class="tab-content">
                            <div class="tab-pan eshow active" id="basic-datatable-preview">
                                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Especialidade</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                
                                
                                    <tbody>
                                        @foreach($records as $record)
                                        <tr>
                                            <td>{{$record->name}}</td>
                                            <td>{{$profession[$record->profession]}}</td>
                                            <td>{{$status[$record->status]}}</td>           
                                        </div>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>                                           
                            </div> <!-- end preview-->
                        
                        </div> <!-- end tab-content-->

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->


    </div>
        <!-- end row-->
                        
</div> <!-- End Content -->
@endsection