@extends('layouts.master')

@section('page-css')
    
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-lg-9 mt-4">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card mb-6 ">
                        <div class="card-body">
                            <div class="card-title mb-4 mt-4 font-weight-bold big-font">Selamat Datang Di Sistem Kelambagaan LLDIKTI 7 </div>
                            <div class="card-subtitle mb-4 text-muted">Example</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-lg-3 mt-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-icon mb-2">
                        <div class="card-body text-center"><i class="bi bi-menu-app"></i>
                            <p class="text-muted mt-1 mb-1">Role</p>
                            <p class="lead text-20 m-0">21</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-icon mb-2">
                        <div class="card-body text-center"><i class="bi bi-people-fill"></i>
                            <p class="text-muted mt-1 mb-1">Users</p>
                            <p class="lead text-20 m-0">{{ $total_users}}</p>
                        </div>
                    </div>
                </div>  
            </div>
        </div>        
    </div>  
    
    <div class="row">
        <div class="col-md-4 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="ul-widget__row">
                        <div class="ul-widget-stat__font"><i class="i-Hotel text-primary"></i></div>
                        <div class="ul-widget__content">
                            <p class="m-0">Assets</p>
                            <h4 class="heading">40,894</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="ul-widget__row">
                        <div class="ul-widget-stat__font"><i class="i-Bar-Chart text-danger"></i></div>
                        <div class="ul-widget__content">
                            <p class="m-0">Progression</p>
                            <h4 class="heading">80%</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="ul-widget__row">
                        <div class="ul-widget-stat__font"><i class="i-Full-Cart text-success"></i></div>
                        <div class="ul-widget__content">
                            <p class="m-0">Total Profit</p>
                            <h4 class="heading">&#x9F3; 2000</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="ul-widget__row">
                        <div class="ul-widget-stat__font"><i class="i-Bookmark text-warning"></i></div>
                        <div class="ul-widget__content">
                            <p class="m-0">Lease</p>
                            <h4 class="heading"> 5,417</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3 ">
        <div class="card mb-4 o-hidden"><img class="card-img-top" src="../../dist-assets/images/photo-wide-3.jpg" alt="" />
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card&apos;s content.</p>
            </div>
            <!-- <ul class="list-group list-group-flush">
                <li class="list-group-item">Cras justo odio</li>
                <li class="list-group-item">Dapibus ac facilisis in</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul> -->
            <div class="card-body"><a class="card-link" href="#">Card link</a><a class="card-link" href="#">Another link</a></div>
        </div>
    </div>
</div>

<style>
    .big-font {
        font-size: 26px; 
        font-family: 'Arial', sans-serif;
    }
    .card-body i.bi {
        font-size: 27px;
        color: #081685;
    }
    .card-size {
    /* Sesuaikan lebar dan tinggi sesuai kebutuhan */
    width: 700px;
    height: 500px;
    /* Tambahkan overflow untuk mengatasi gambar yang lebih besar dari kartu */
    overflow: hidden;
}
    
</style>


@endsection

@section('page-js')
    
@endsection
