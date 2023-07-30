@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Data Pemasukan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-income" class="table table-striped table-hover table-sm">
                            <thead class="text-bg-primary">
                            <tr>
                                <th>Tanggal</th>
                                <th>Uraian</th>
                                <th>Debet</th>
                                <th>Action</th>
                                <th>#</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Form Pemasukan</h4>
                </div>
                <div class="card-body">
                    <form id="form-cashout">
                        <input type="hidden" id="id">
                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <input type="date" id="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="desc">Uraian</label>
                            <input type="text" id="desc" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="debit">Debit</label>
                            <input type="number" id="debit" class="form-control">
                        </div>

                        <button class="btn btn-primary mt-4">Simpan</button>
                        <button type="button" id="cancel" class="btn btn-danger mx-2 mt-4" style="display: none">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            let date = $('#date')
            let desc = $('#desc')
            let debit = $('#debit')
            let id = $('#id')

            let edit = false

            function clearForm() {
                desc.val('')
                debit.val('')
                id.val('')
            }

            $('#cancel').on('click', function () {
                $(this).hide()
                edit = false
                clearForm()
            })

            let tableCashout = $('#table-income').DataTable({
                serverSide: true,
                processing: true,
                stateSave: true,
                order: [[4, 'desc']],
                ajax: '/datatable-income',
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'desc', name: 'desc', sortable: false},
                    {data: 'rp_debit', name: 'rp_debit'},
                    {data: 'action', name: 'action', sortable: false},
                    {data: 'created_at', name: 'created_at'}
                ],
                columnDefs: [
                    {
                        target: 4,
                        visible: false
                    }
                ]
            })

            $('#form-cashout').on('submit', function (e) {
                e.preventDefault()

                let payload = {
                    date: date.val(),
                    desc: desc.val(),
                    debit: debit.val()
                }

                $.ajax({
                    url: edit ? `/api/api/income/update/${id.val()}` : '/api/api/income',
                    method: edit ? 'PUT' : 'POST',
                    data: payload
                }).then(function () {
                    clearForm()
                    $('#cancel').hide()
                    edit = false
                    tableCashout.ajax.reload()
                })
            })

            tableCashout.on('click', 'tr .edit', function () {
                let data = tableCashout.row($(this).closest('tr')).data()

                date.val(data.date)
                desc.val(data.desc)
                debit.val(data.debit)
                id.val(data.id)
                edit = true

                $('#cancel').show()
            })

            tableCashout.on('click', 'tr .delete', function () {
                let data = tableCashout.row($(this).closest('tr')).data()

                $.ajax({
                    url: `/api/api/income/delete/${data.id}`,
                    method: 'DELETE',
                }).then(function () {
                    tableCashout.ajax.reload()
                })
            })
        })
    </script>
@endpush
