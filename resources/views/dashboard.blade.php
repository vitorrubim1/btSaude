@extends("layouts.app")
@section('content')
<div class="row">
        
    <div class="col-lg-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Ligações Efetuadas">Ligações Efetuadas</h5>
                        <h3 class="my-2 py-1">0</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 0.00%</span>
                        </p>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <div id="campaign-sent-chart" data-colors="#536de6"></div>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div> <!-- end col -->

    <div class="col-lg-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="New Leads">Ligações Recusadas</h5>
                        <h3 class="my-2 py-1">0</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> 0.00%</span>
                        </p>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <div id="new-leads-chart" data-colors="#10c469"></div>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div> <!-- end col -->

    <div class="col-lg-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Faturamento Mensal">Faturamento Mensal</h5>
                        <h3 class="my-2 py-1">R$ 0,00</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 0.00%</span>
                        </p>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <div id="deals-chart" data-colors="#536de6"></div>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div> <!-- end col -->

    <div class="col-lg-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="text-muted font-weight-normal mt-0 text-truncate" title="Faturamento Total">Faturamento Total</h5>
                        <h3 class="my-2 py-1">R$ 0,00</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 0.00%</span>
                        </p>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            <div id="booked-revenue-chart" data-colors="#10c469"></div>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div> <!-- end col -->
</div>
<!-- end row -->
@endsection