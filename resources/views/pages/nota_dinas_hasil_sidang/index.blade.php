@extends('partials.master')

@section('content')
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card card-animation">
            <div class="card-header">
                <h4 class="card-title">Periode Sidang Data Pelanggaran</h4>
                <small>*pilih periode sidang data pelanggaran untuk cetak dokumen nota dinas hasil putusan sidang</small>
            </div>
            <div class="card-body">
                <form action="javascript:void(0)" id="form-periode">
                    @csrf
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="col-md-2 col-12">
                            &nbsp;
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="start">Bulan Mulai Periode Sidang</label>
                                <input  type="month" name="month_start" id="start" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2 col-12 mt-3">
                            <h5 class="text-center"> - </h5>
                            {{-- <input  type="month" name="month_start" id="start" class="form-control"> --}}
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="end">Bulan Akhir Periode Sidang</label>
                                <input  type="month" name="month_end" id="end" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2 col-12">
                            &nbsp;
                        </div>
                    </div>

                    <div class="d-flex justify-content-end flex-grow-1 mt-4">
                        <button type="submit" class="btn btn-primary">Cetak ND Hasil Putusan Sidang Disiplin</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Data Kasus Selesai</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="table-responsive table-card px-3">
                    <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">No Nota Dinas</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Pelapor</th>
                                <th scope="col">Terlapor</th>
                                <th scope="col">Pangkat</th>
                                <th scope="col">Nama Korban</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            getData()
        });

        function getData() {
            var table = $('#data-data').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('nd-hasil-putusan-sidang.data') }}",
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}'
                    }
                },
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'no_nota_dinas',
                        name: 'no_nota_dinas'
                    },
                    {
                        data: 'tanggal_kejadian',
                        name: 'tanggal_kejadian'
                    },
                    {
                        data: 'pelapor',
                        name: 'pelapor'
                    },
                    {
                        data: 'terlapor',
                        name: 'terlapor'
                    },
                    {
                        data: 'pangkat',
                        name: 'pangkat'
                    },
                    {
                        data: 'nama_korban',
                        name: 'nama_korban'
                    },
                    {
                        data: 'status.name',
                        name: 'status.name'
                    },
                ]
            });
            $('#kt_search').on('click', function(e) {
                e.preventDefault();
                table.table().draw();
            });
        }

        $('#form-periode').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `nd-hasil-sidang/print`,
                method: 'POST',
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
                    console.log(res)
                    window.location.href = `/download-file/${res.document_data}`

                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Berhasil generate dan download dokumen',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    setTimeout(() => {
                        window.location.reload()
                    }, 2000);
                },
                error: (xhr) => {
                    $.LoadingOverlay("hide");
                    onAjaxError(xhr)
                }
            })
        })
    </script>
@endsection
