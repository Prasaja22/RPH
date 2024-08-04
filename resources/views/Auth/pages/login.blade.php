@extends('Auth.layouts')

@section('pages')
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

          <div class="card mb-3">

            <div class="card-body">

              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Login Ke Dashboard!</h5>
                <p class="text-center small">Inputkan email dan password anda pada form berikut.</p>
              </div>

              <form method="POST" class="row g-3 needs-validation" novalidate action="/login">
                @csrf
                {{-- Email input --}}
                <div class="col-12">
                  <label for="yourUsername" class="form-label">Email</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <div class="invalid-feedback">Inputkan Email Anda!</div>
                  </div>
                </div>

                {{-- Password Input --}}
                <div class="col-12">
                  <label for="yourPassword" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="password" required>
                  <div class="invalid-feedback">Inputkan Email Anda!</div>
                </div>
                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit">Login</button>
                </div>
                <div class="col-12">
                  <p class="small mb-0">Tidak memiliki akun? Kontak Admin untuk mendaftarkan Anda.</p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

</section>
@endsection
