@extends('Dashboard.layouts')

@section('pages')
<div class="pagetitle">
    <h1>Teams</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Order / Teams</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Form Team.</h5>

                  <!-- Horizontal Form -->
                  <form method="POST" action="/tambah-team">
                    @csrf
                    <div class="row mb-3">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input required name="nama_team" type="text" class="form-control" id="inputText">
                      </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Line</label>
                        <div class="col-sm-10">
                            <input required name="line" type="text" class="form-control" id="inputText">
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

    <div class="col-lg-12">
        <div class="card overflow-auto">
            <div class="card-body">
              <h5 class="card-title">Order</h5>
              <p>Data tabel order.</p>

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      No
                    </th>
                    <th>Nama Team</th>
                    <th>Line</th>
                    <th>Aksi</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->line }}</td>
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
                                    <form class="row g-3" action="/edit-team/{{$item->id}}" method="POST">
                                        @csrf
                                        @method('put')
                                        <div class="col-12">
                                          <label for="inputNanme4" class="form-label">Your Name</label>
                                          <input required name="nama_team" type="text" class="form-control" id="inputText" value="{{$item->name}}">
                                        </div>
                                        <div class="col-12">
                                          <label for="inputEmail4" class="form-label">Line</label>
                                          <input required name="line" type="text" class="form-control" id="inputText" value="{{$item->line}}">
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
                                Apakah anda yakin akan menghapus data team <b>{{$item->name}}</b>?
                                <form method="post" action="/hapus-team/{{$item->id}}">
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
