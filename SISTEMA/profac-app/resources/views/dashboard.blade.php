<x-app-layout>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">

                            <div id="chart"></div>


                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="ibox ">
                    <div class="ibox-content d-flex align-items-center" style="height: 22.8rem !important" >

                            <div id="chart2" style="width:100%"></div>


                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ibox ">
                    <div class="ibox-content">

                            <div id="chart3"></div>


                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="ibox ">
                    <div class="ibox-content">

                            <div id="chart4"></div>


                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-content">

                            <div id="chart5"></div>


                    </div>
                </div>
            </div>

            <div class="col-lg-6" >
                <div class="ibox "  >
                    <div class="ibox-content d-flex align-items-center" style="height: 31.4rem !important" >

                            <div id="chart6" style="width:50rem" ></div>

                    </div>
                </div>
            </div>
        </div>


    </div>




<script>


    var options = {
        series: [{
            name: 'Pago de Planilla Cliente-1',
            data: [310, 400, 280, 510, 420, 1090, 1000]
        }, {
            name: 'Pago de Planilla Cliente-2',
            data: [110, 320, 450, 320, 340, 520, 410]
        }],
        chart: {
            height: 350,
            type: 'area'
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        xaxis: {
            type: 'date',
            categories: ["2022-01-01", "2022-01-15", "2022-02-01", "2022-02-15", "2022-03-01", "2022-03-15",
                "2022-04-01"
            ]
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    //------------------------------------------------------------------------------------------//



    $(document).ready(function() {
        // barras Chart
        Morris.Bar({
            element: 'barras-charts',
            data: [{
                    y: '2006',
                    a: 95,
                    b: 70
                },
                {
                    y: '2007',
                    a: 75,
                    b: 65
                },
                {
                    y: '2008',
                    a: 50,
                    b: 40
                },
                {
                    y: '2009',
                    a: 75,
                    b: 65
                },
                {
                    y: '2010',
                    a: 50,
                    b: 40
                },
                {
                    y: '2011',
                    a: 75,
                    b: 65
                },
                {
                    y: '2012',
                    a: 100,
                    b: 90
                }
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Total Income', 'Total Outcome'],
            lineColors: ['#ff9b44', '#fc6075'],
            lineWidth: '3px',
            barColors: ['#ff9b44', '#fc6075'],
            resize: true,
            redraw: true
        });
        // lineas Chart
        Morris.Line({
            element: 'lineas-charts',
            data: [{
                    y: '2006',
                    a: 50,
                    b: 90
                },
                {
                    y: '2007',
                    a: 75,
                    b: 65
                },
                {
                    y: '2008',
                    a: 50,
                    b: 40
                },
                {
                    y: '2009',
                    a: 75,
                    b: 65
                },
                {
                    y: '2010',
                    a: 50,
                    b: 40
                },
                {
                    y: '2011',
                    a: 75,
                    b: 65
                },
                {
                    y: '2012',
                    a: 100,
                    b: 50
                }
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Total Sales', 'Total Revenue'],
            lineColors: ['#ff9b44', '#fc6075'],
            lineWidth: '3px',
            resize: true,
            redraw: true
        });
    });
</script>

<script>
    var options = {
        series: [2, 92, 10, 10, 7],
        chart: {
            type: 'donut',
        },
        labels: ["Minutos Perdidos", "Minutos Trabajados", "Minutos de Lonche", "Minutos de Pivot",
            "Minutos Extra"],
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart2"), options);
    chart.render();
</script>

<script>
     var options = {
      series: [44, 55, 67, 83],
      chart: {
      height: 350,
      type: 'radialBar',
    },
    plotOptions: {
      radialBar: {
        dataLabels: {
          name: {
            fontSize: '22px',
          },
          value: {
            fontSize: '16px',
          },
          total: {
            show: true,
            label: 'Total',
            formatter: function (w) {
              // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
              return 249
            }
          }
        }
      }
    },
    labels: ['Cliente 1', 'Cliente 2', 'Cliente 3', 'Cliente 4'],
    };

    var chart = new ApexCharts(document.querySelector("#chart3"), options);
    chart.render();
</script>

<script>
            var options = {
      series: [75],
      chart: {
      height: 350,
      type: 'radialBar',
      toolbar: {
        show: true
      }
    },
    plotOptions: {
      radialBar: {
        startAngle: -135,
        endAngle: 225,
         hollow: {
          margin: 0,
          size: '70%',
          background: '#fff',
          image: undefined,
          imageOffsetX: 0,
          imageOffsetY: 0,
          position: 'front',
          dropShadow: {
            enabled: true,
            top: 3,
            left: 0,
            blur: 4,
            opacity: 0.24
          }
        },
        track: {
          background: '#fff',
          strokeWidth: '67%',
          margin: 0, // margin is in pixels
          dropShadow: {
            enabled: true,
            top: -3,
            left: 0,
            blur: 4,
            opacity: 0.35
          }
        },

        dataLabels: {
          show: true,
          name: {
            offsetY: -10,
            show: true,
            color: '#888',
            fontSize: '17px'
          },
          value: {
            formatter: function(val) {
              return parseInt(val);
            },
            color: '#111',
            fontSize: '36px',
            show: true,
          }
        }
      }
    },
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        type: 'horizontal',
        shadeIntensity: 0.5,
        gradientToColors: ['#ABE5A1'],
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100]
      }
    },
    stroke: {
      lineCap: 'round'
    },
    labels: ['Asistencia procesada'],
    };

    var chart = new ApexCharts(document.querySelector("#chart4"), options);
    chart.render();
</script>

<script>

    var options = {
      series: [
      {
        name: 'Jornada 1',
        data: [
          {
            x: 'Cliente 1',
            y: [
              new Date('2019-03-05').getTime(),
              new Date('2019-03-08').getTime()
            ]
          },
          {
            x: 'Cliente 2',
            y: [
              new Date('2019-03-02').getTime(),
              new Date('2019-03-05').getTime()
            ]
          },
          {
            x: 'Cliente 2',
            y: [
              new Date('2019-03-05').getTime(),
              new Date('2019-03-07').getTime()
            ]
          },
          {
            x: 'Cliente 3',
            y: [
              new Date('2019-03-03').getTime(),
              new Date('2019-03-09').getTime()
            ]
          },
          {
            x: 'Cliente 3',
            y: [
              new Date('2019-03-08').getTime(),
              new Date('2019-03-11').getTime()
            ]
          },
          {
            x: 'Cliente 4',
            y: [
              new Date('2019-03-11').getTime(),
              new Date('2019-03-16').getTime()
            ]
          },
          {
            x: 'Cliente 1',
            y: [
              new Date('2019-03-01').getTime(),
              new Date('2019-03-03').getTime()
            ],
          }
        ]
      },
      {
        name: 'Jornada 2',
        data: [
          {
            x: 'Cliente 1',
            y: [
              new Date('2019-03-02').getTime(),
              new Date('2019-03-05').getTime()
            ]
          },
          {
            x: 'Cliente 3',
            y: [
              new Date('2019-03-06').getTime(),
              new Date('2019-03-16').getTime()
            ],
            goals: [
              {
                name: 'Break',
                value: new Date('2019-03-10').getTime(),
                strokeColor: '#CD2F2A'
              }
            ]
          },
          {
            x: 'Cliente 2',
            y: [
              new Date('2019-03-03').getTime(),
              new Date('2019-03-07').getTime()
            ]
          },
          {
            x: 'Cliente 5',
            y: [
              new Date('2019-03-20').getTime(),
              new Date('2019-03-22').getTime()
            ]
          },
          {
            x: 'Cliente 1',
            y: [
              new Date('2019-03-10').getTime(),
              new Date('2019-03-16').getTime()
            ]
          }
        ]
      },
      {
        name: 'Jornada 3',
        data: [
          {
            x: 'Cliente 2',
            y: [
              new Date('2019-03-10').getTime(),
              new Date('2019-03-17').getTime()
            ]
          },
          {
            x: 'Cliente 4',
            y: [
              new Date('2019-03-05').getTime(),
              new Date('2019-03-09').getTime()
            ],
            goals: [
              {
                name: 'Break',
                value: new Date('2019-03-07').getTime(),
                strokeColor: '#CD2F2A'
              }
            ]
          },
        ]
      }
    ],
      chart: {
      height: 450,
      type: 'rangeBar'
    },
    plotOptions: {
      bar: {
        horizontal: true,
        barHeight: '80%'
      }
    },
    xaxis: {
      type: 'datetime'
    },
    stroke: {
      width: 1
    },
    fill: {
      type: 'solid',
      opacity: 0.6
    },
    legend: {
      position: 'top',
      horizontalAlign: 'left'
    }
    };

    var chart = new ApexCharts(document.querySelector("#chart5"), options);
    chart.render();
</script>

<script>

         var options = {
      series: [{
        name: "Cliente 1 - Numero de Empleados",
        data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
      },
      {
        name: "Cliente 2 - Numero de Empleados",
        data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
      },
      {
        name: 'Cliente 3 - Numero de Empleados',
        data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
      }
    ],
      chart: {
      height: 350,
      type: 'line',
      zoom: {
        enabled: false
      },
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: [5, 7, 5],
      curve: 'straight',
      dashArray: [0, 8, 5]
    },
    title: {
      text: 'Cantidad de empledos por mes',
      align: 'left'
    },
    legend: {
      tooltipHoverFormatter: function(val, opts) {
        return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
      }
    },
    markers: {
      size: 0,
      hover: {
        sizeOffset: 6
      }
    },
    xaxis: {
      categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
        '10 Jan', '11 Jan', '12 Jan'
      ],
    },
    tooltip: {
      y: [
        {
          title: {
            formatter: function (val) {
              return val + " (mins)"
            }
          }
        },
        {
          title: {
            formatter: function (val) {
              return val + " per session"
            }
          }
        },
        {
          title: {
            formatter: function (val) {
              return val;
            }
          }
        }
      ]
    },
    grid: {
      borderColor: '#f1f1f1',
    }
    };

    var chart = new ApexCharts(document.querySelector("#chart6"), options);
    chart.render();
</script>



</x-app-layout>

