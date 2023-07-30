<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Daily Report</title>

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
    <div class="container">
        <h1 class="text-center">Daily Report</h1>
        <h2 class="text-center">{{ $date }}</h2>
    </div>
    <div class="row my-5">
        <div class="col">
            <table class="table table-bordered table-sm">
                <thead>
                <th>Tanggal</th>
                <th>Uraian</th>
                <th>Debit</th>
                <th>Kredit</th>
                </thead>

                <tbody>
                @foreach($data as $key => $value)
                    <tr>
                        <td style="vertical-align: middle; text-align: center; font-weight: bold" rowspan="{{ count($value) }}">{{ $key }}</td>
                    @foreach($value as $k)
                        <td>{{ $k->desc }}</td>
                        <td>{{ $k->debit ? $formatter->formatCurrency($k->debit, 'IDR') : '-' }}</td>
                        <td>{{ $k->credit ? $formatter->formatCurrency($k->credit, 'IDR') : '-' }}</td>
                    </tr>
                    @endforeach
                    <tr class="table-info">
                        <td style="font-weight: bold; text-align: end" colspan="2">Total</td>
                        <td style="font-weight: bold">{{ $formatter->formatCurrency($value->sum('debit'), 'IDR') }}</td>
                        <td style="font-weight: bold">{{ $formatter->formatCurrency($value->sum('credit'), 'IDR') }}</td>
                    </tr>
                    <tr class="saldo">
                        <td colspan="2" style="font-weight: bold; text-align: end">Saldo</td>
                        <td colspan="2" style="font-weight: bold; text-align: center">{{ $k->credit || $k->debit ? $formatter->formatCurrency($value->sum('debit') - $value->sum('credit'), 'IDR') : '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
