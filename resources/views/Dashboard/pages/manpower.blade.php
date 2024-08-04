@extends('Dashboard.layouts')

@section('pages')
<div class="pagetitle">
    <h1>Manpower</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Manpower / Data</li>
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

        @if ($teamsCheck > 0)
        <div class="col-lg-6">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Data Entry.</h5>

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
                              <form method="POST" enctype="multipart/form-data" action="/manpower-import">
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
                              <h5 class="card-title">Form Manpower</h5>

                              <!-- Horizontal Form -->
                              <form method="POST" action="/simpan-manpower">
                                @csrf
                                <div class="row mb-3">
                                  <label for="inputEmail3" class="col-sm-2 col-form-label">Noreg</label>
                                  <div class="col-sm-10">
                                    <input required type="text" name="noreg" class="form-control" id="noreg">
                                  </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                      <input required type="text" name="nama" class="form-control" id="nama">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Team</label>
                                    <div class="col-sm-10">
                                      <select name="team" id="team" class="form-control">
                                        <option value="" selected disabled>Pilih Team</option>
                                        @foreach ($teams as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
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
                        <form method="post" action="/reset-manpower">
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
            Harap Inputkan Data Team Terlebih Dahulu.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif


    </div>

    <div class="col-lg-12">
        <div class="card overflow-auto">
            <div class="card-body">
              <h5 class="card-title">Manpower</h5>
              <p>Data tabel Manpower.</p>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      No
                    </th>
                    <th>Noreg</th>
                    <th>Nama</th>
                    <th>Team Name</th>
                    <th>Line</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->noreg }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->team->name }}</td>
                      <td>{{ $item->team->line}}</td>
                      <td>
                        <!-- Modal Edit -->
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#verticalycenteredEdit{{$item->id}}">
                            Edit
                        </button>
                        <div class="modal fade" id="verticalycenteredEdit{{$item->id}}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title">Vertically Centered</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row g-3" action="/edit-manpower/{{$item->id}}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="col-12">
                                            <label for="inputNanme4" class="form-label">No Reg.</label>
                                            <input required name="noreg" type="text" class="form-control" id="inputText" value="{{$item->noreg}}">
                                        </div>
                                        <div class="col-12">
                                          <label for="inputNanme4" class="form-label">Your Name</label>
                                          <input required name="nama_team" type="text" class="form-control" id="inputText" value="{{$item->name}}">
                                        </div>
                                        <div class="col-12">
                                          <label for="inputEmail4" class="form-label">Team</label>
                                          <select name="team" id="team" class="form-control">
                                            @foreach ($teams as $itemTeams)
                                                <option value="{{$itemTeams->id}}" {{ $item->team->name == $itemTeams->name ? 'selected' : '' }} >{{$itemTeams->name}}</option>
                                            @endforeach
                                          </select>
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
                                <h5 class="modal-title">Hapus Team</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Apakah anda yakin akan menghapus Manpower <b>{{$item->name}}</b>?
                                <form method="post" action="/hapus-manpower/{{$item->id}}">
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
