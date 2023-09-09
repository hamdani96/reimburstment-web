@extends('layouts.app')

@push('plugin-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="page-title-box">
            {{-- end row --}}
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Halo {{ Auth::user()->name }} ({{ Auth::user()->job_position }})</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">reimbursment app</a></li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end page-title -->

    </div>

</div>
<!-- content -->
@endsection

@push('plugin-js')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
{{-- diagram cdn --}}
@endpush
