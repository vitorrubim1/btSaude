@extends('layouts.app')

@section('content')
<div class="content">
        <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                @if(isset($show))
                <a href="{{url("specialtie/".$entity->id."/edit")}}" class="btn btn-info"><i class="fas fa-edit "></i> Editar</a>
                @endif
                <a href="{{url("specialtie")}}" class="btn btn-info"><i class="fas fa-arrow-left "></i> Voltar</a>
            </div>
            <h4 class="page-title">Especialidades</h4>
        </div>
    </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="header-title">Usuários</h4> --}}
                        <div class="row">
                    <div class="col-lg-12">
                        {{-- <form method="POST" action="{{url("specialtie")}}" enctype="multipart/form-data"> --}}
                        <form method="POST" action="{{ isset($entity) ? route('specialtie.update',$entity->id) : route('specialtie.store') }}" enctype="multipart/form-data">
                        @if( isset($entity) ) <input type="hidden" name="_method" value="PUT" /> @endif    
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="simpleinput">Nome</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                </div>      
                            </div>                          
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="simpleinput">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="1" {{@$entity->status == 1 ? 'selected' : ''}}>Ativo</option>
                                            <option value="0" {{@$entity->status == 0 ? 'selected' : ''}}>Inativo</option>
                                        </select> 
                                    </div>
                                </div>
                            </div>

                            @if(!isset($show))
                            <div class="card-footer">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="far fa-dot-circle"></i> Salvar</button>
                                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Resetar</button>
                            </div>
                            @endif
                        </form>
                    </div> <!-- end col -->
                </div>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->


    </div>
        <!-- end row-->
                        
</div> <!-- End Content -->
@endsection