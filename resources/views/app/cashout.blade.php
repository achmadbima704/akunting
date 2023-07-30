@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Data Pengeluaran</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-cashout" class="table table-sm table-striped table-hover">
                            <thead class="text-bg-primary">
                            <tr>
                                <th>Tanggal</th>
                                <th>Uraian</th>
                                <th>Kredit</th>
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
                    <h4>Form Pengeluaran</h4>
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
                            <label for="credit">Kredit</label>
                            <input type="number" id="credit" class="form-control">
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
            let credit = $('#credit')
            let id = $('#id')

            let edit = false

            function clearForm() {
                desc.val('')
                credit.val('')
                id.val('')
            }

            $('#cancel').on('click', function () {
                $(this).hide()
                edit = false
                clearForm()
            })

            let tableCashout = $('#table-cashout').DataTable({
                serverSide: true,
                stateSave: true,
                processing: true,
                order: [[4, 'desc']],
                ajax: '/datatable-cashout',
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'desc', name: 'desc', sortable: false},
                    {data: 'rp_credit', name: 'rp_credit'},
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
                    credit: credit.val()
                }

                $.ajax({
                    url: edit ? `/api/cashout/update/${id.val()}` : '/api/cashout',
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
                credit.val(data.credit)
                id.val(data.id)
                edit = true

                $('#cancel').show()
            })

            tableCashout.on('click', 'tr .delete', function () {
                let data = tableCashout.row($(this).closest('tr')).data()

                $.ajax({
                    url: `api/cashout/delete/${data.id}`,
                    method: 'DELETE',
                }).then(function () {
                    tableCashout.ajax.reload()
                })
            })
        })
    </script>
@endpush
