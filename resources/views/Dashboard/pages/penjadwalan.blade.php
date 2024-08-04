@extends('Dashboard.layouts')

@section('pages')
<div class="pagetitle">
    <h1>Penjadwalan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Penjadwalan</li>
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

        @if ($manpowerCheck > 0)
        <div class="col-lg-6">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Data Entry.</h5>

                <!-- Accordion without outline borders -->
                <div class="accordion accordion-flush" id="accordionFlushExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            Print Penjadwalan.
                          </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                          <div class="accordion-body">
                            {{-- Import Excel --}}
                            <div class="card">
                                <div class="card-body">
                                  <h5 class="card-title">Silahkan pilih tanggal.</h5>

                                  <!-- Horizontal Form -->
                                  <form method="POST" action="{{ route('get.print') }}">
                                    @csrf
                                    <div class="row mb-3">
                                      <label for="inputEmail3" class="col-sm-2 col-form-label">Tanggal</label>
                                      <div class="col-sm-10">
                                        <input name="date" type="date" class="form-control">
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

                    {{-- form input --}}
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Tambah Penjadwalan.
                      </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body">
                        <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Form Schedule</h5>

                              <!-- Horizontal Form -->
                              <form method="POST" action="/simpan-schedule">
                                @csrf
                                <div class="row mb-3">
                                  <label for="inputEmail3" class="col-sm-2 col-form-label">Tanggal</label>
                                  <div class="col-sm-10">
                                    <input required type="date" class="form-control" id="date" name="date" required>
                                  </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Line</label>
                                    <div class="col-sm-10">
                                        <input  required type="text" class="form-control" id="line" name="line" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Shift</label>
                                    <div class="col-sm-10">
                                        <select name="shift" class="form-control" id="shift">
                                            <option value="1">Shift-1</option>
                                            <option value="2">Shift-2</option>
                                        </select>
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
                </div><!-- End Accordion without outline borders -->

              </div>
            </div>

          </div>
      </div>
        @else
        <div class="alert alert-danger alert-dismissible fade show col-lg-6" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            Harap inputkan Data Manpower Terlebih Dahulu.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif


    </div>

    <div class="col-lg-12">
        <div class="card overflow-auto">
            <div class="card-body">
              <h5 class="card-title">Penjadwalan</h5>
              <p>Data tabel Penjadwalan.</p>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      No
                    </th>
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <th>Line</th>
                    <th>Aksi</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ \Carbon\Carbon::parse($item->date)->locale('id')->translatedFormat('l, j F Y') }}</td>
                      <td>{{ $item->shift }}</td>
                      <td>{{ $item->line }}</td>
                      <td>
                        <!-- Modal Edit -->
                        <a type="button" class="btn btn-info text-white" href="/schedule-add-details/{{$item->id}}">
                            <i class="ri-article-fill"></i>
                        </a>

                        <!-- Modal Delete -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycenteredDelete{{$item->id}}">
                            <i class="ri-delete-bin-3-fill"></i>
                        </button>
                        <div class="modal fade" id="verticalycenteredDelete{{$item->id}}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Hapus Penjadwalan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Apakah anda yakin akan menghapus Penjadwalan hari <b>{{\Carbon\Carbon::parse($item->date)->locale('id')->translatedFormat('l, j F Y')}}</b> untuk Shift-{{$item->shift}}?
                                <form method="post" action="/hapus-penjadwalan/{{$item->id}}">
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
