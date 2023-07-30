<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Laporan Rata - Rata</title>

    <style>
        .saldo td {
            background-color: yellow;
        }
        @media print {
            .saldo {
                background-color: yellow !important;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="row my-5" style="margin: 0 auto">
            <div class="col-md-5">
                <table class="table table-bordered">
                    <thead>
                    <th>Tanggal</th>
                    <th>Omset</th>
                    </thead>

                    <tbody>
                        @foreach($data as $key => $value)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $formatter->formatCurrency($value->sum('debit') - $value->sum('credit'), 'IDR') }}</td>
                            </tr>
                        @endforeach
                    <tr>
                        <th style="text-align: end">Total</th>
                        <th>{{ $formatter->formatCurrency($total_omset, 'IDR') }}</th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-5">
                <table class="table table-bordered">
                    <tr>
                        <td style="font-weight: bold" class="p-4 text-center">Rata - rata Omset</td>
                        <td style="font-weight: bold" class="p-4 text-center">{{ $formatter->formatCurrency($avg, 'IDR') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
