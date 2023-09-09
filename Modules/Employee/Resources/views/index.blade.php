@extends('layouts.app')

@push('plugin-css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
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
                            <a href="{{ route('employee.index') }}">Karyawan</a>
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
                                <h6 class="font-weight-bold mb-3">Karyawan</h6>
                                <button class="btn btn-primary font-weight-bold mb-3" data-toggle="modal" data-target="#create-employee"> <i class="fa fa-plus"></i> Tambah Karyawan</button>
                            </div>

                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered dt-responsive nowrap datatable" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No </th>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>JABATAN</th>
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

<div class="modal fade" id="create-employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Karyawan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="employee-form" autocomplete="off" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="">Nama Karyawan</label>
                        <input type="text" name="name" required id="name" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label for="">NIP</label>
                        <input type="number" name="nip" required id="nip" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label for="">Jabatan</label>
                        <select name="job_position" required id="" class="form-control">
                            <option value="" disabled selected> Pilih Jabatan</option>
                            <option value="DIREKTUR">DIREKTUR</option>
                            <option value="FINANCE">FINANCE</option>
                            <option value="STAFF">STAFF</option>
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <label for="">Password</label>
                        <input type="password" name="password" required id="" class="form-control">
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

<div class="modal fade" id="edit-employee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Karyawan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="employee-edit-form" autocomplete="off" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-12">
                        <label for="">Nama Karyawan</label>
                        <input type="text" name="name" required id="edit-name" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label for="">NIP</label>
                        <input type="number" name="nip" required id="edit-nip" class="form-control">
                    </div>
                    <div class="form-group col-12">
                        <label for="">Jabatan</label>
                        <select name="job_position" required id="edit-job-position" class="form-control">
                            <option value="" disabled selected> Pilih Jabatan</option>
                            <option value="DIREKTUR">DIREKTUR</option>
                            <option value="FINANCE">FINANCE</option>
                            <option value="STAFF">STAFF</option>
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <label for="">Password Baru</label>
                        <input type="password" name="password" id="" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn text-danger" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary" id="btn-update">Update</button>
            </div>
        </form>
      </div>
    </div>
</div>

<!-- content -->
@endsection

@push('plugin-js')
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endpush

@push('custom-js')

    <script>
        $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                info: true,
                filter: true,
                ajax: "{{ route('employee.ajax') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'id'},
                    {data: 'nip', name: 'nip'},
                    {data: 'name', name: 'name'},
                    {data: 'job_position', name: 'job_position'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
        });

        $('#employee-form').submit(function(event) {
            event.preventDefault();

            const formData = $(this).serialize();

            $.ajax({
            url: '{{ route('employee.store') }}',
            type: 'POST',
            data: formData,
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
                        message: "Karyawan Berhasil Ditambah.",
                        position: "topRight",
                    });
                    
                    $("#btn-tambah").prop("disabled", false);
                    $('#employee-form')[0].reset();
                    $('.datatable').DataTable().ajax.reload();
                    $('#create-employee').modal('hide');
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

        // delete employee
        $(document).on('click', '.employee-delete', function() {
            var id = $(this).data('id');

            Swal.fire({
                icon: 'warning',
                title: 'Hapus Karyawan',
                html: 'Anda yakin akan lanjut menghapus data karyawan ini ini?',
                showCancelButton: true,
                confirmButtonText: 'Lanjut',
                cancelButtonText: 'Kembali',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('employee.index') }}/'+ id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {        
                            if (response.code == 200) {
                                iziToast.success({
                                    title: "Berhasil",
                                    message: "Karyawan Berhasil Di Hapus",
                                    position: "topRight",
                                });
                                
                                $('.datatable').DataTable().ajax.reload();
                            }
                        },
                        error: function(err) {
                            alert('Error ketika hapus data!. coba beberapa saat lagi');
                        }
                    });
                }
            });
        });

        // edit employee
        $(document).on('click', '.employee-edit', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '{{ route('employee.edit', ':id') }}'.replace(':id', id),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $("#employee-edit").prop("disabled", true);
                },
                complete: function () {
                    $("#employee-edit").prop("disabled", false);
                },
                success: function(response) {
                    // console.log(response);
                    var data = response.data;
                    $('#edit-name').val(data.name);
                    $('#edit-nip').val(data.nip);
                    $('#edit-job-position').val(data.job_position);
                    
                    $('#edit-employee').modal('show');
                    $("#employee-edit").prop("disabled", true);
                },
                error: function(err) {
                    alert('Error ketika submit data!. coba beberapa saat lagi');
                }
            });

            // update data
            $('#employee-edit-form').submit(function(event) {
                event.preventDefault();

                const formData = $(this).serialize();

                $.ajax({
                url: '{{ route('employee.update', ':id') }}'.replace(':id', id),
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
                            message: "Karyawan Berhasil Di Update.",
                            position: "topRight",
                        });
                        
                        $("#btn-edit").prop("disabled", false);
                        $('#employee-edit-form')[0].reset();
                        $('.datatable').DataTable().ajax.reload();
                        $('#edit-employee').modal('hide');
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
        
    </script>
@endpush
