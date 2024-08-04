@extends('Dashboard.layouts')

@section('pages')
<div class="pagetitle">
    <h1>Order</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Order / Order Data</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-5" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger alert-dismissible fade show col-lg-6" role="alert">
                        <i class="bi bi-exclamation-octagon me-1"></i>
                        {{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                @endforeach
            </div>
        @endif

        @if ($partnumberCheck > 0)
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Entry Data.</h5>
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                              Import data.
                            </button>
                          </h2>
                          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                              {{-- Import Excel --}}
                              <div class="card">
                                  <div class="card-body">
                                    <h5 class="card-title">Silahkan upload file excel anda.</h5>

                                    <!-- Horizontal Form -->
                                    <form method="POST" enctype="multipart/form-data" action="/import-order">
                                      @csrf
                                      <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">File</label>
                                        <div class="col-sm-10">
                                          <input name="file" type="file" class="form-control" id="inputText">
                                        </div>
                                      </div>
                                      <div class="text-start">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                      </div>
                                    </form><!-- End Horizontal Form -->

                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                              Input Manual.
                            </button>
                          </h2>
                          <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                              <div class="card">
                                  <div class="card-body">
                                    <h5 class="card-title">Form Data Order</h5>

                                    <!-- Horizontal Form -->
                                    <form method="POST" action="/simpan-order">
                                      @csrf
                                      <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Item ID</label>
                                        <div class="col-sm-10">
                                          <select name="item_id"  class="form-control" >
                                            <option value="" disabled selected>Pilih Item Id</option>
                                            @foreach ($partnumber as $item)
                                                <option value="{{$item->id}}">{{$item->item_id}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                          <label for="inputEmail3" class="col-sm-2 col-form-label">Customer</label>
                                          <div class="col-sm-10">
                                            <input required type="text" name="customer" class="form-control" id="nama">
                                          </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Date</label>
                                        <div class="col-sm-10">
                                          <input required type="date" name="date" class="form-control" id="nama">
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Jumlah Order</label>
                                        <div class="col-sm-10">
                                          <input required type="number" name="jumlah_order" class="form-control" id="nama">
                                        </div>
                                      </div>
                                      <div class="text-start">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                      </div>
                                    </form><!-- End Horizontal Form -->

                                  </div>
                                </div>
                            </div>
                            </div>
                          </div>
                        </div>

                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycenteredReset">
                          Reset Data
                        </button>

                        <div class="modal fade" id="verticalycenteredReset" tabindex="-1">
                          <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                              <div class="modal-header">
                              <h5 class="modal-title">Reset Data Manpower</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                              Apakah anda yakin akan reset data manpower? Seluruh data akan hilang!
                              <form method="post" action="/reset-order">
                                  @csrf
                                  @method('delete')
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Hapus</button>
                                  </div>
                              </form>
                              </div>
                          </div>
                          </div>
                        </div>
                      </div><!-- End Accordion without outline borders -->

                    </div>

                </div>
            </div>
        </div>
        @else
        <div class="alert alert-danger alert-dismissible fade show col-lg-6" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            Harap Inputkan Data Partnumber Terlebuh Dahulu.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
      </div>
    </div>

    <div class="col-lg-12">
        <div class="card overflow-auto">
            <div class="card-body">
              <h5 class="card-title">Order</h5>
              <p>Data tabel order.</p>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Item Id.</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Jumlah Order</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->partnumber->item_id }}</td> <!-- Tambahkan pengecekan null -->
                        <td>{{ $item->customer }}</td>
                        <td>{{ $item->date }}</td>
                        <td>{{ $item->jumlah_order }}</td>
                        <td>
                            <!-- Modal Edit -->
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#verticalycenteredEdit{{$item->id}}">
                                Edit
                            </button>
                            <div class="modal fade" id="verticalycenteredEdit{{$item->id}}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">Form Partnumber</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form class="row g-3" action="/edit-order/{{$item->id}}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="col-12">
                                                <label for="inputNanme4" class="form-label">Item Id.</label>
                                                <select name="item_id" class="form-control">
                                                    <option value="" disabled selected>Pilih Item Id</option>
                                                    @foreach ($partnumber as $part)
                                                        <option value="{{$part->id}}" {{ $item->partnumber->item_id == $part->item_id ? 'selected' : '' }}>{{$part->item_id}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12">
                                            <label for="inputNanme4" class="form-label">Customer</label>
                                            <input required type="text" name="customer" class="form-control" id="nama" value="{{$item->customer}}">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputNanme4" class="form-label">Date</label>
                                                <input required type="date" name="date" class="form-control" id="nama" value="{{$item->date}}">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputNanme4" class="form-label">Jumlah Order</label>
                                                <input required type="number" name="jumlah_order" class="form-control" id="nama" value="{{$item->jumlah_order}}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form><!-- Vertical Form -->
                                    </div>
                                </div>
                                </div>
                            </div>

                            <!-- Modal Delete -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycenteredDelete{{$item->id}}">
                                Hapus
                            </button>
                            <div class="modal fade" id="verticalycenteredDelete{{$item->id}}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">Hapus Partnumber</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    Apakah anda yakin akan menghapus Data order?
                                    <form method="post" action="/hapus-order/{{$item->id}}">
                                        @csrf
                                        @method('delete')
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Hapus</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

              <!-- End Table with stripped rows -->

            </div>
          </div>
    </div>
  </section>
@endsection
