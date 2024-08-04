@extends('Dashboard.layouts')

@section('pages')
<div class="pagetitle">
    <h1>Lot Number</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Order / Lot Number</li>
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
                                <form method="POST" enctype="multipart/form-data" action="/import-lotnumber">
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
                                <h5 class="card-title">Form Lotnumber</h5>

                                <!-- Horizontal Form -->
                                <form method="POST" action="/simpan-lotnumber">
                                  @csrf
                                  {{-- date picker buat bessok --}}
                                  {{-- <div class="row mb-3">
                                    <label for="month_year_picker" class="col-sm-2 col-form-label">Pilih Bulan dan Tahun</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="month_year_picker" class="form-control" name="month_year" placeholder="Pilih Bulan dan Tahun">
                                    </div>
                                  </div> --}}
                                  <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Partnumber</label>
                                    <div class="col-sm-10">
                                      <select name="partnumber_id" id="partnumber_id" class="form-control">
                                        <option value="" disabled selected>Pilih Partnumber</option>
                                        @foreach ($partnumber as $item)
                                        <option value="{{$item->id}}">{{$item->partnumber}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                  <div class="row mb-3">
                                      <label for="inputEmail3" class="col-sm-2 col-form-label">Lotnumber</label>
                                      <div class="col-sm-10">
                                        <input type="text" name="lotnumber" class="form-control" id="nama" required>
                                      </div>
                                  </div>
                                  <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Qty.</label>
                                    <div class="col-sm-10">
                                      <input type="number" name="qty" class="form-control" id="qty" required>
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
                          <form method="post" action="/reset-lotnumber">
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
              <h5 class="card-title">Lotnumber</h5>
              <p>Data tabel lotnumber.</p>
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      No
                    </th>
                    <th>Part Number</th>
                    <th>Lotnumber</th>
                    <th>Qty</th>
                    <th>Aksi</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->partnumber->partnumber }}</td>
                      <td>{{ $item->lotnumber }}</td>
                      <td>{{ $item->qty }}</td>
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
                                    <form class="row g-3" action="/edit-lotnumber/{{$item->id}}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="col-12">
                                            <label for="inputNanme4" class="form-label">Partnumber</label>
                                            <select name="partnumber_id" id="partnumber_id" class="form-control">
                                                <option value="" disabled selected>Pilih Partnumber</option>
                                                @foreach ($partnumber as $value)
                                                <option value="{{$value->id}}" {{ $value->partnumber == $item->partnumber->partnumber ? 'selected' : '' }} >{{$value->partnumber}}</option>
                                                @endforeach
                                              </select>
                                        </div>
                                        <div class="col-12">
                                          <label for="inputNanme4" class="form-label">Lotnumber</label>
                                          <input required type="text" name="lotnumber" class="form-control" id="nama" value="{{$item->lotnumber}}">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputNanme4" class="form-label">Qty.</label>
                                            <input required type="text" name="qty" class="form-control" id="nama" value="{{$item->qty}}">
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
                                <form method="post" action="/hapus-lotnumber/{{$item->id}}">
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
