@extends('layouts.master')

@section('page-css')
    
@endsection

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-lg-12 mt-4">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="card mb-2 ">
                        <div class="card-body">
                            <div class="card-title mb-2 mt-3 font-weight-bold big-font">Selamat Datang Di Sistem Kelambagaan LLDIKTI 7 </div>
                            <div class="card-subtitle mb-2 text-muted">Example</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    
    <div class="row mt-3">
        <div class="col-md-3 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="ul-widget__row">
                        <div class="ul-widget-stat__font"><i class="fa-solid fa-building" style="color: #eb0000;"></i></div>
                        <div class="ul-widget__content">
                            <p class="m-0">Badan Penyelenggara</p>
                            <h4 class="heading">40,894</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="ul-widget__row">
                        <div class="ul-widget-stat__font">
                            <i class="fa-solid fa-building-columns fa-flip-horizontal" style="color: #013184;"></i>
                        </div>
                        <div class="ul-widget__content">
                            <p class="m-0">Perguruan Tinggi</p>
                            <h4 class="heading">80%</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="ul-widget__row">
                        <div class="ul-widget-stat__font"><i class="fa-solid fa-medal" style="color: #FFD43B;"></i></div>
                        <div class="ul-widget__content">
                            <p class="m-0">Akreditasi</p>
                            <h4 class="heading">&#x9F3; 2000</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="ul-widget__row">
                        <div class="ul-widget-stat__font"><i class="fa-solid fa-globe" style="color: #229801;"></i></div>
                        <div class="ul-widget__content">
                            <p class="m-0">Perguruan Tinggi Aktif</p>
                            <h4 class="heading"> 5,417</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-8 col-md-8">
            <div class="card o-hidden">
                <div class="ul-weather-card__bg-img">
                    <img class="img-fluid" src="https://images3.alphacoders.com/784/thumbbig-78425.webp" alt="alt" />
                </div>
                <div class="ul-weather-card__img-overlay-2">
                    <div class="d-flex no-block align-items-center">
                        <h5 class="t-font-bold text-white">Surabaya</h5>
                    </div>
                    <div>
                        <h5 id="current-day" class="text-white big-font font-weight-bold mt-2"></h5> 
                        <h6 id="current-date" class="text-white mt-1"></h6>
                    </div>
                </div>                    
            </div>
        </div>
        <div class="col-md-3 col-lg-3">
            <div class="card mt-4 mb-4 o-hidden">
                <div class="card-body">
                    <div class="ul-widget__row-v2">
                        <div id="gradientRadial"></div>
                        <div class="ul-widget__content-v2">
                            <h4 class="heading mt-3">People Choice Rate</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .big-font {
        font-size: 38px; 
        font-family: 'Arial', sans-serif;
    }
    .card-body i.bi {
        font-size: 27px;
        color: #081685;
    }
    .card-size {
        /* Sesuaikan lebar dan tinggi sesuai kebutuhan */
        width: 700px;
        height: 500px;
        /* Tambahkan overflow untuk mengatasi gambar yang lebih besar dari kartu */
        overflow: hidden;
    }
</style>

@section('page-js')
<script>
    function updateDateTime() {
        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const today = new Date();
        const dayName = days[today.getDay()];
        const date = today.getDate();
        const month = today.getMonth() + 1; // Months are zero-based
        const year = today.getFullYear();

        document.getElementById('current-day').innerText = dayName;
        document.getElementById('current-date').innerText = `${date}-${month}-${year}`;
    }

    document.addEventListener('DOMContentLoaded', updateDateTime);

    var chart = new ApexCharts(document.querySelector("#gradientRadial"), options);
    chart.render(); 
    
    var options = {
      chart: {
        height: 250,
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
            margin: 0,
            // margin is in pixels
            dropShadow: {
              enabled: true,
              top: -3,
              left: 0,
              blur: 4,
              opacity: 0.35
            }
          },
          dataLabels: {
            showOn: 'always',
            name: {
              offsetY: 1,
              show: true,
              color: '#888',
              fontSize: '15px'
            },
            value: {
              formatter: function formatter(val) {
                return parseInt(val);
              },
              color: '#111',
              fontSize: '12px',
              show: true
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
          gradientToColors: ['#e6af4b'],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100]
        }
      },
      series: [55],
      stroke: {
        lineCap: 'round'
      },
      labels: ['Pending']
    };
</script>
@endsection

@endsection
