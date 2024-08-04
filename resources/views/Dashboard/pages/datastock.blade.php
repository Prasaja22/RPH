@extends('Dashboard.layouts')

@section('pages')
<div class="pagetitle">
    <h1>Data Stock</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Order / Data stock</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show col-lg-6" role="alert">
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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Entry Data.</h5>

                   <!-- Accordion without outline borders -->
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
                                <form method="POST" enctype="multipart/form-data" action="/import-data-stock">
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
                                <h5 class="card-title">Form Data Stock</h5>

                                <!-- Horizontal Form -->
                                <form method="POST" action="/simpan-data-stock">
                                  @csrf
                                  <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Item ID.</label>
                                    <div class="col-sm-10">
                                      <select name="partnumber_id" id="item_id" class="form-control">
                                        <option value="" disabled selected>Pilih Partnumber</option>
                                        @foreach ($partnumber as $item)
                                        <option value="{{$item->id}}">{{$item->item_id}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label for="month_year_picker" class="col-sm-2 col-form-label">Bulan & Tahun</label>
                                    <div class="col-sm-10">
                                        <input type="text" autocomplete="off" id="month_year_picker" class="form-control" name="date" placeholder="Pilih Bulan dan Tahun">
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Stock</label>
                                    <div class="col-sm-10">
                                      <input type="number" name="stock" class="form-control" id="qty" required>
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
                          <form method="post" action="/reset-data-stock">
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
              <h5 class="card-title">Data Stock</h5>
              <p>Data tabel stock.</p>
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      No
                    </th>
                    <th>Item Id.</th>
                    <th>Partnumber</th>
                    <th>Stock</th>
                    <th>Date</th>
                    <th>Aksi</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->partnumber->item_id }}</td>
                      <td>{{ $item->partnumber->partnumber }}</td>
                      <td>{{ $item->stock }}</td>
                      <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $item->date)->locale('id')->translatedFormat('F, Y') }}</td>
                      <td>
                        <!-- Modal Edit -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#verticalycenteredEdit{{$item->id}}">
                            Edit
                        </button>
                        <div class="modal fade" id="verticalycenteredEdit{{$item->id}}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Form Lotnumber</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row g-3" action="/edit-data-stock/{{$item->id}}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="col-12">
                                            <label for="inputNanme4" class="form-label">Item ID.</label>
                                              <select name="partnumber_id" id="item_id" class="form-control">
                                                <option value="" disabled selected>Pilih Partnumber</option>
                                                @foreach ($partnumber as $value)
                                                <option value="{{$value->id}}" {{ $value->item_id == $item->partnumber->item_id ? 'selected' : '' }}>{{$value->item_id}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                        <div class="col-12">
                                          <label for="inputNanme4" class="form-label">Date</label>
                                          <input type="text" class="form-control" name="date" placeholder="Pilih Bulan dan Tahun" value="{{$item->date}}">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputNanme4" class="form-label">Stock.</label>
                                            <input required type="text" name="stock" class="form-control" id="nama" value="{{$item->stock}}">
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
                                <h5 class="modal-title">Hapus Lotnumber</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Apakah anda yakin akan menghapus Partnumber <b>{{$item->lotnumber}}</b>?
                                <form method="post" action="/hapus-datastock/{{$item->id}}">
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
                      <td></td>
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
