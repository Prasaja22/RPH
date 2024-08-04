@extends('Dashboard.layouts')

@section('pages')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row">

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

              <div class="card-body">
                <h5 class="card-title">Order</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="ri-gift-fill"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{$orderWidget}}</h6>
                    <span class="text-success small pt-1 fw-bold">Total</span> <span class="text-muted small pt-2 ps-1">order.</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title">Manpower</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="ri-emotion-fill"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $manpower }}</h6>
                    <span class="text-success small pt-1 fw-bold">Total</span> <span class="text-muted small pt-2 ps-1">manpower tersedia</span>

                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->

          <!-- Customers Card -->
          <div class="col-xxl-4 col-xl-12">

            <div class="card info-card customers-card">

              <div class="card-body">
                <h5 class="card-title">Ready Stock Products</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="ri-luggage-cart-fill"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{ $sumOnStock }}</h6>
                    <span class="text-danger small pt-1 fw-bold">Total</span> <span class="text-muted small pt-2 ps-1">products ready.</span>

                  </div>
                </div>

              </div>
            </div>

          </div><!-- End Customers Card -->

          <!-- Reports -->
          <div class="col-12">
            <div class="card">


              <div class="card-body">
                <h5 class="card-title">Reports Order Per 3 Bulan ini.</h5>

                <!-- Area Chart -->
                <div id="reportsChart"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const totalOrders = @json($totalOrders);
                        const salesData = totalOrders.map(order => order.total);
                        const categories = totalOrders.map(order => order.partnumber.partnumber); // Ambil nama produk dari partnumber

                        new ApexCharts(document.querySelector("#reportsChart"), {
                            series: [{
                                name: 'Total Orders',
                                data: salesData,
                            }],
                            chart: {
                                height: 350,
                                type: 'area', // Ubah tipe menjadi area
                                toolbar: {
                                    show: false
                                },
                            },
                            markers: {
                                size: 4
                            },
                            colors: ['#3FA2F6'], // Warna garis
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.3, // Ubah opacityFrom untuk efek yang lebih kuat
                                    opacityTo: 0.4,// Ubah opacityTo untuk efek yang lebih kuat
                                    stops: [0, 90, 100],
                                    colorStops: [
                                        {
                                            offset: 0,
                                            color: '#96C9F4', // Warna gradient dari garis
                                            opacity: 0.6 // Opacity untuk bagian bawah
                                        },
                                        {
                                            offset: 100,
                                            color: '#CAF4FF', // Warna untuk bagian bawah (putih)
                                            opacity: 0.1 // Opacity untuk bagian bawah
                                        }
                                    ]
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                curve: 'smooth',
                                width: 3 // Mengatur ketebalan garis
                            },
                            xaxis: {
                                categories: categories, // Gunakan nama produk sebagai kategori
                            },
                            tooltip: {
                                x: {
                                    format: 'dd/MM/yy'
                                },
                            }
                        }).render();
                    });
                </script>
                <!-- End Area Chart -->
            </div>





            </div>
          </div><!-- End Reports -->

          <!-- Recent Sales -->
          <div class="col-12">
            <div class="card recent-sales overflow-auto">

              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>

                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Penjadwalan Hari ini</h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Date</th>
                      <th scope="col">Line</th>
                      <th scope="col">Shift</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($schedules as $item)
                    <tr>
                      <th>{{$loop->iteration}}</th>
                      <td>{{$item->date}}</td>
                      <td>{{$item->line}}</td>
                      <td>{{$item->shift}}</td>
                      <td>
                        <a type="button" class="btn btn-info text-white" href="/schedule-add-details/{{$item->id}}">
                            <i class="ri-article-fill"></i>
                        </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>

            </div>
          </div><!-- End Recent Sales -->

        </div>
      </div><!-- End Left side columns -->

      <!-- Right side columns -->
      <div class="col-lg-4">

        <!-- Website Traffic -->
        <div class="card">

          <div class="card-body pb-0">
            <h5 class="card-title">Stock Data Chart</h5>

            <div id="trafficChart" style="min-height: 600px;" class="echart"></div>

            <script>
                document.addEventListener("DOMContentLoaded", () => {
                  var chartData = @json($chartData);

                  echarts.init(document.querySelector("#trafficChart")).setOption({
                    tooltip: {
                      trigger: 'item'
                    },
                    legend: {
                      type: 'scroll', // Enables scrolling for legend
                      orient: 'horizontal', // Horizontal orientation
                      top: '0%',
                      left: 'center',
                      bottom: 'auto',
                      right: 'auto',
                      pageButtonPosition: 'end', // Positioning page buttons at the end
                      pageIcons: {
                        horizontal: ['M 22 12 L 3 22 L 3 2 Z', 'M 2 12 L 21 2 L 21 22 Z'] // Custom icons for page buttons
                      },
                      pageIconSize: 15,
                      pageTextStyle: {
                        color: '#000'
                      }
                    },
                    series: [{
                      name: 'Stocks : ',
                      type: 'pie',
                      radius: ['40%', '70%'],
                      avoidLabelOverlap: false,
                      label: {
                        show: false,
                        position: 'center'
                      },
                      emphasis: {
                        label: {
                          show: true,
                          fontSize: '18',
                          fontWeight: 'bold'
                        }
                      },
                      labelLine: {
                        show: false
                      },
                      data: chartData
                    }]
                  });
                });
                </script>


          </div>
        </div><!-- End Website Traffic -->

        <!-- News & Updates Traffic -->


      </div><!-- End Right side columns -->

    </div>
  </section>
@endsection
