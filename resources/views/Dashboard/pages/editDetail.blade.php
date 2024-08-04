@extends('Dashboard.layouts')

@section('pages')
<div class="pagetitle">
    <h1>Edit Detail Schedule</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Manpower / <a href="/penjadwalan">Penjadwalan</a> /  Detail Schedule</li>
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
        <div class="col-lg-6">

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Data Entry.</h5>

                <!-- Accordion without outline borders -->

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('details.update', $detail->id) }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="mb-3">
                        <label for="partnumber" class="form-label">Partnumber</label>
                        <select class="form-control" id="partnumber" name="partnumber" disabled required>
                            <option value="" disabled>Pilih Partnumber</option>
                            @foreach ($partnumber as $item)
                                <option value="{{ $item->partnumber }}" {{ $item->partnumber == $detail->partnumber ? 'selected' : '' }}>{{ $item->partnumber }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="team" class="form-label">Team</label>
                        <select class="form-control" id="team" disabled name="team" required>
                            <option value="" disabled>Pilih Team</option>
                            @foreach ($teams as $item)
                                <option value="{{ $item->name }}" {{ $item->name == $detail->team ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="plan" class="form-label">Plan</label>
                        <input type="number" disabled class="form-control" id="plan" name="plan" value="{{ $detail->plan }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="act" class="form-label">Act</label>
                        <input type="number" class="form-control" id="act" name="act" value="{{ $detail->act }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>

              </div>
            </div>

          </div>
      </div>
    </div>
  </section>
@endsection
