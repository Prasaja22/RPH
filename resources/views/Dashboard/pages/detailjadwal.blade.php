@extends('Dashboard.layouts')

@section('pages')

<div class="pagetitle">
    <h1>Penjadwalan</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
        <li class="breadcrumb-item active">Manpower / Penjadwalan</li>
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
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                           <b>[{{ $schedule->date }} - Line {{ $schedule->line }} - Shift-{{ $schedule->shift }}]</b>
                        </button>
                      </h2>
                      <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                          <div class="card">
                              <div class="card-body">
                                <h5 class="card-title">Form Schedule</h5>
                                 {{-- form --}}
                                 <form id="addDetailForm" action="{{ route('schedules.addDetail', $schedule->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="partnumber" class="form-label">Partnumber</label>
                                        <select class="form-control" id="partnumber" name="partnumber" required>
                                            <option value="" disabled selected>Pilih Partnumber</option>
                                            @foreach ($partnumber as $item)
                                                <option value="{{$item->partnumber}}">{{$item->partnumber}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="team" class="form-label">Team</label>
                                        <select class="form-control" id="team" name="team" required>
                                            <option value="" disabled selected>Pilih Team</option>
                                            @foreach ($teams as $item)
                                                <option value="{{$item->name}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="plan" class="form-label">Plan</label>
                                        <input type="number" class="form-control" id="plan" name="plan" required>
                                    </div>
                                    <hr>
                                    <div id="lotNumberQtyContainer">
                                        <div class="lot-qty-group">
                                            <h5 class="card-title">Lotnumber & Qty</h5>
                                            <label for="lot_no" class="form-label">Lot No</label>
                                            {{-- <input type="text" class="form-control mb-3" name="lot_no[]" required> --}}
                                            <select name="lot_no[]" class="form-control mb-3">
                                                <option value="" selected disabled>Pilih Lotnumber</option>
                                                @foreach ($lotnumber as $item)
                                                    <option value="{{$item->lotnumber}}">{{$item->lotnumber}}</option>
                                                @endforeach
                                            </select>
                                            <label for="qty" class="form-label">Qty</label>
                                            <input type="number" class="form-control mb-3" name="qty[]" required>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary mb-3" id="addLotQty"><i class="ri-add-circle-fill"></i> Tambah</button>

                                    <div class="mb-3">
                                        <label for="act" class="form-label">Act</label>
                                        <input type="number" class="form-control" id="act" name="act" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Simpan Schedule</button>
                                </form>
                                 {{-- end form --}}
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
    </div>

    <div class="col-lg-12">
        <div class="card overflow-auto">
            <div class="card-body">
              <h5 class="card-title">{{ \Carbon\Carbon::parse($schedule->date)->locale('id')->translatedFormat('l, j F Y') }}</h5>
              <p><b>LINE {{ $schedule->line }}</b></p>

              <table class="custom-table">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Partnumber</th>
                        <th rowspan="2">Team</th>
                        <th rowspan="2">Plan</th>
                        <th rowspan="2">Lotnumber</th>
                        <th rowspan="2">Qty</th>
                        <th colspan="2" class="no-border">Target/Jam</th>
                        <th rowspan="2">Act</th>
                        <th rowspan="2">Opsi</th>
                    </tr>
                    <tr>
                        <th>10:00</th>
                        <th>14:00</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mergedDetails as $index => $detail)
                    <tr>
                        <td rowspan="{{ count($detail['lot_numbers']) }}">{{ $loop->iteration }}</td>
                        <td rowspan="{{ count($detail['lot_numbers']) }}">{{ $detail['partnumber'] }}</td>
                        <td rowspan="{{ count($detail['lot_numbers']) }}">{{ $detail['team'] }}</td>
                        <td rowspan="{{ count($detail['lot_numbers']) }}">{{ $detail['plan'] }}</td>
                        <td>{{ $detail['lot_numbers'][0]['lot_no'] }}</td>
                        <td>{{ $detail['lot_numbers'][0]['qty'] }}</td>
                        <td rowspan="{{ count($detail['lot_numbers']) }}">{{ round($detail['target_perjam_1']) }}</td>
                        <td rowspan="{{ count($detail['lot_numbers']) }}">{{ round($detail['target_perjam_2']) }}</td>
                        <td rowspan="{{ count($detail['lot_numbers']) }}">{{ $detail['act'] }}</td>
                        <td rowspan="{{ count($detail['lot_numbers']) }}">
                            <!-- Edit -->
                            <a class="btn btn-success" href="{{ route('details.edit', $detail['id'])}}?partnumber={{ $detail['partnumber'] }}&schedule_id={{ $detail['id_schedule'] }}"><i class="ri-edit-box-fill"></i></a>
                            <!-- Modal Delete -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#verticalycenteredDelete{{$detail['id']}}">
                                <i class="ri-delete-bin-2-fill"></i>
                            </button>
                            <div class="modal fade" id="verticalycenteredDelete{{$detail['id']}}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">Hapus Penjadwalan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    Apakah anda yakin akan hapus schedule untuk <b>{{$detail['partnumber']}}</b> {{ $detail['id_schedule'] }}?
                                    <form method="post" action="/hapus-detail-schedule/{{$detail['id']}}?partnumber={{ $detail['partnumber'] }}&schedule_id={{ $detail['id_schedule'] }}">
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
                    @for ($i = 1; $i < count($detail['lot_numbers']); $i++)
                    <tr>
                        <td>{{ $detail['lot_numbers'][$i]['lot_no'] }}</td>
                        <td>{{ $detail['lot_numbers'][$i]['qty'] }}</td>
                    </tr>
                    @endfor
                    @endforeach
                </tbody>
            </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
    </div>
  </section>

  <script>
    document.getElementById('addLotQty').addEventListener('click', function() {
        var container = document.getElementById('lotNumberQtyContainer');
        var newGroup = document.createElement('div');
        newGroup.classList.add('lot-qty-group', 'mb-3');
        newGroup.innerHTML = `
            <h5 class="card-title">Lotnumber & Qty</h5>
            <label for="lot_no" class="form-label">Lot No</label>
            <select name="lot_no[]" class="form-control mb-3">
                <option value="" selected disabled>Pilih Lotnumber</option>
                    @foreach ($lotnumber as $item)
                        <option value="{{$item->lotnumber}}">{{$item->lotnumber}}</option>
                    @endforeach
            </select>
            <label for="qty" class="form-label">Qty</label>
            <input type="number" class="form-control mb-3" name="qty[]" required>
            <button type="button" class="btn btn-danger remove-lot-qty"><i class="ri-delete-back-2-fill"></i> Kuarangi</button>
            <hr>
        `;
        container.appendChild(newGroup);
    });

    document.getElementById('lotNumberQtyContainer').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-lot-qty')) {
            event.target.closest('.lot-qty-group').remove();
        }
    });
</script>

@endsection
