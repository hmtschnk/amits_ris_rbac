@extends('layouts.app') 
@section('content')
@include('layouts.navbars.auth.topnav') 
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-xl-10 mx-auto mt-5">
            
            <div class="card shadow-lg border-0 bg-white min-height-300">
                <div class="card-body p-5 d-flex flex-col justify-content-center align-items-center text-center">
                    
                    
                    <div class="icon icon-shape icon-xl bg-gray-100 rounded-circle text-center mb-4 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fa fa-hospital-user text-primary" style="font-size: 2.5rem;"></i>
                    </div>

                    
                    <h2 class="text-dark font-weight-bolder mb-2 tracking-tight">
                        Welcome to AMITS NR Radiology Information System
                    </h2>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection