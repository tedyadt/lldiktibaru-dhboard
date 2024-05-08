@extends('layouts.master')

@section('page-css')
    
@endsection

@section('main-content')
@php
$pertiId = $_GET['id_perti'];
@endphp

<div class="main-content pt-4">
    <div class="breadcrumb">
        <ul>
            <li>
                <a href="{{ route('perguruan-tinggi' ) }}">Perguruan Tinggi</a> |
                <a href="{{ route('perguruan-tinggi.show', $pertiId ) }}">Detail</a> |
                <a href="{{ route('program-studi', ['id_perti'=> $pertiId ]) }}">Program Studi</a> |
            </li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div><!-- end of main-content -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                        @include('program_studi.datatable.index')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
    {{-- datatable button --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


    @include('program_studi.datatable.js')

@endsection