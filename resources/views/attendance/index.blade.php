@extends('layouts.app')

@section('content')
<div class="content">
        <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Atendimentos</h4>
        </div>
    </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title">Usuários</h4> --}}
                        
                        <div class="tab-content">
                            <div class="tab-pane show active" id="basic-datatable-preview">
                                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                
                                
                                    <tbody>
                                        @foreach($records as $record)
                                        <tr>
                                            <td>{{$record->id}}</td>                                           
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