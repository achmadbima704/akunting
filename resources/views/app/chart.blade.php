<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Grafik</title>
</head>
<body>
<div class="mx-5">
    <canvas id="myChart"></canvas>
</div>
<div class="mx-5">
    <canvas id="line-chart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    fetch('/api/chart-data/{{$date}}')
        .then((res) => res.json())
        .then((data) => {
            console.log(data)
            const ctx = document.getElementById('myChart');
            const ctx1 = document.getElementById('line-chart');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    datasets: [{
                        label: 'Omset Per Hari',
                        data: data
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Omset',
                            padding: {
                                top: 20,
                                bottom: 20
                            },
                            font: {
                                size: 24
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                }
            });

            new Chart(ctx1, {
                type: 'line',
                data: {
                    datasets: [{
                        label: 'Omset Per Hari',
                        borderColor: 'red',
                        data: data
                    }]
                },
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: 'Omset',
                            padding: {
                                top: 20,
                                bottom: 20
                            },
                            font: {
                                size: 24
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                }
            });
        })

</script>
</body>
</html>
