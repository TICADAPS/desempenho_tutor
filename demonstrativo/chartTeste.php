<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>AGSUS - Demonstrativo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
        <!-- Custom fonts for this template-->
        <link rel="shortcut icon" href="../img_agsus/iconAdaps.png"/>
        <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.4.0/dist/chartjs-plugin-datalabels.min.js"></script>
        <style>
            ul {margin-left: -18px;}
            .tooltip-inner {
                background-color: #0f547cad;
            }
            .tooltip.bs-tooltip-right .arrow:before {
                border-right-color: #0f547cad !important;
            }
            .tooltip.bs-tooltip-left .arrow:before {
                border-left-color: #0f547cad !important;
            }
            .tooltip.bs-tooltip-bottom .arrow:before {
                border-bottom-color: #0f547cad !important;
            }
            .tooltip.bs-tooltip-top .arrow:before {
                border-top-color: #0f547cad !important;
            }
            
            
            .canvas-con {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 365px;
                position: relative;
              }

              .canvas-con-inner {
                height: 100%;
              }

              .canvas-con-inner, .legend-con {
                display: inline-block;
              }

              .legend-con {
                font-family: Roboto;
                display: inline-block;
              }
              .legend-con ul {
                list-style: none;
              }
              .legend-con li {
                display: flex;
                align-items: center;
                margin-bottom: 4px;
              }
              .legend-con li span {
                display: inline-block;
              }
              .legend-con li span.chart-legend {
                width: 25px;
                height: 25px;
                margin-right: 10px;
              }
        </style>
    </head>

    <body>
        <div class="container-fluid p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <div class="canvas-con">
                        <div class="canvas-con-inner">
                            <canvas id="mychart" height="250px"></canvas>
                        </div>
                        <div id="my-legend-con" class="legend-con"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="../../vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../../vendor/chart.js/Chart.min.js"></script>
        <script>
        //radar
        var chartData = [{"visitor": 39, "visit": 1}, {"visitor": 18, "visit": 2}, {"visitor": 9, "visit": 3}, {"visitor": 5, "visit": 4}, {"visitor": 6, "visit": 5}, {"visitor": 5, "visit": 6}]

        var visitorData = [],
            visitData = [];

        for (var i = 0; i < chartData.length; i++) {
            visitorData.push(chartData[i]['visitor']);
            visitData.push(chartData[i]['visit']);
        }

        var myChart = new Chart(document.getElementById('mychart'), {
            type: 'doughnut',
            animation:{
                animateScale:true
            },
            data: {
                labels: visitData,
                datasets: [{
                    label: 'Visitor',
                    data: visitorData,
                    backgroundColor: [
                        "#a2d6c4",
                        "#36A2EB",
                        "#3e8787",
                        "#579aac",
                        "#7dcfe8",
                        "#b3dfe7",
                    ]
                }]
            },
            options: {
                responsive: true,
                legend: false,
                legendCallback: function(chart) {
                    var legendHtml = [];
                    legendHtml.push('<ul>');
                    var item = chart.data.datasets[0];
                    for (var i=0; i < item.data.length; i++) {
                        legendHtml.push('<li>');
                        legendHtml.push('<span class="chart-legend" style="background-color:' + item.backgroundColor[i] +'"></span>');
                        legendHtml.push('<span class="chart-legend-label-text">' + item.data[i] + ' person - '+chart.data.labels[i]+' times</span>');
                        legendHtml.push('</li>');
                    }

                    legendHtml.push('</ul>');
                    return legendHtml.join("");
                },
                tooltips: {
                     enabled: true,
                     mode: 'label',
                     callbacks: {
                        label: function(tooltipItem, data) {
                            var indice = tooltipItem.index;
                            return data.datasets[0].data[indice] + " person visited " + data.labels[indice] + ' times';
                        }
                     }
                 },
                 plugins: {
                    datalabels: {
                       formatter: (value, ctx) => {
                          let sum = 0;
                          let dataArr = ctx.chart.data.datasets[0].data;
                          dataArr.map(data => {
                              sum += data;
                          });
                          let percentage = (value*100 / sum).toFixed(2)+"%";
                          return percentage;
                },
                color: '#fff',
            }
        }
            }
        });

        $('#my-legend-con').html(myChart.generateLegend());

        console.log(document.getElementById('my-legend-con'));
        </script>
    </body>
</html>