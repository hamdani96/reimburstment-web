@extends('layouts.app')

@push('plugin-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('modules/dropify/css/dropify.min.css') }}">
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="page-title-box">
            {{-- row --}}
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4 class="page-title">Karyawan</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('reimbursement.index') }}">Reimbursment</a>
                        </li>
                    </ol>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end page-title -->


        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12 d-flex justify-content-between">
                                <h6 class="font-weight-bold mb-3">Reimbursment</h6>
                                <button class="btn btn-primary font-weight-bold mb-3" data-toggle="modal" data-target="#create-reimbursment"> <i class="fa fa-plus"></i> Tambah Reimbursment</button>
                            </div>

                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No </th>
                                                <th>Tanggal</th>
                                                <th>Karyawan</th>
                                                <th>Nama</th>
                                                <th>Deskripsi</th>
                                                <th>File</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="create-reimbursment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Reimbursment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="reimbursement-form" method="post">
            <div class="modal-body">
                <div class="row">
                    @if (Auth::user()->job_position != 'STAFF')
                    <div class="form-group col-12">
                        <label for="">Pilih Karyawan</label>
                        <select name="user_id" class="form-control" id="">
                            <option value="" disabled selected>Pilih Karyawan</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="user_id" value="">
                    @endif
                    <div class="form-group col-12">
                        <label for="">Nama Reimbursment</label>
                        <input type="text" name="name" required id="name" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label for="">Tanggal</label>
                        <input type="date" name="date" required id="date" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label for="">Deskripsi <span class="text-primary">(opsional)</span></label>
                        <textarea name="description" class="form-control" id="" cols="4" rows="4"></textarea>
                    </div>
                    <div class="form-group col-12">
                        <label for="">File <span class="text-primary">(opsional)</span></label>
                        <input type="file" class="dropify @error('file') is-invalid @enderror" name="file" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-tambah">Tambah</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="edit-reimbursment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Reimbursment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="reimbursement-update-form" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="">Status</label>
                        <select name="status" class="form-control" id="edit-status">
                            <option value="pending">Pending</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-danger" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-update">Update Status</button>
            </div>
        </form>
      </div>
    </div>
  </div>

<!-- content -->
@endsection

@push('plugin-js')
    {{-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('modules/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-js')

    <script>
        $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            info: true,
            filter: true,
            ajax: "{{ route('reimbursement.ajax') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'date', name: 'date'},
                {data: 'user_name', name: 'user_name'},
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'file', name: 'file'},
                {data: 'status', name: 'status'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
        });

        $('#reimbursement-form').submit(function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            $.ajax({
                url: '{{ route('reimbursement.store') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $("#btn-tambah").prop("disabled", true);
                },
                complete: function () {
                    $("#btn-tambah").prop("disabled", false);
                },
                success: function(response) {
                    if(response.code === 200) {
                        iziToast.success({
                            title: "Berhasil",
                            message: "Reimbursement Berhasil Ditambah.",
                            position: "topRight",
                        });
                        
                        $("#btn-tambah").prop("disabled", false);
                        $('#reimbursement-form')[0].reset();
                        $('.datatable').DataTable().ajax.reload();
                        $('#create-reimbursment').modal('hide');
                    } else {
                        iziToast.error({  // Mengubah iziToast.success menjadi iziToast.error untuk menunjukkan pesan error
                            title: "Gagal",
                            message: response.data,
                            position: "topRight",
                        });
                    }
                },
                error: function(err) {
                    // alert('Error ketika submit data!. coba beberapa saat lagi');
                    console.log(err);
                }
            });
        });

        $(document).on('click', '.reimbursment-edit', function() {
            var id = $(this).data("id");

            $.ajax({
                url: '{{ route('reimbursement.edit', ':id') }}'.replace(':id', id),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $("#reimbursment-edit").prop("disabled", true);
                },
                complete: function () {
                    $("#reimbursment-edit").prop("disabled", false);
                },
                success: function(response) {
                    var data = response.data;
                    $('#edit-status').val(data.status);
                    
                    $('#edit-reimbursment').modal('show');
                    $("#reimbursment-edit").prop("disabled", true);
                },
                error: function(err) {
                    alert('Error ketika submit data!. coba beberapa saat lagi');
                }
            });

            // update data
            $('#reimbursement-update-form').submit(function(event) {
                event.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                url: '{{ route('reimbursement.update', ':id') }}'.replace(':id', id),
                type: 'PUT',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $("#btn-edit").prop("disabled", true);
                },
                complete: function () {
                    $("#btn-edit").prop("disabled", false);
                },
                success: function(response) {
                    if(response.code === 200) {
                        iziToast.success({
                            title: "Berhasil",
                            message: "Reimbursement Berhasil Di Update.",
                            position: "topRight",
                        });
                        
                        $("#btn-edit").prop("disabled", false);
                        $('#reimbursement-update-form')[0].reset();
                        $('.datatable').DataTable().ajax.reload();
                        $('#edit-reimbursment').modal('hide');
                    } else {
                        iziToast.success({
                            title: "Gagal",
                            message: response.data,
                            position: "topRight",
                        });
                    }
                },
                error: function(err) {
                    alert('Error ketika submit data!. coba beberapa saat lagi');
                }
                });
            });
        });
    </script>

    <script>
        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove':  'Remove',
                'error':   'Ooops, something wrong happended.'
            }
        });
    </script>
@endpush
