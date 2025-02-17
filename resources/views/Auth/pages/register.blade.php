@extends('Auth.layouts')

@section('pages')
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

          <div class="card mb-3">

            <div class="card-body">

              <div class="pt-4 pb-2">
                <h5 class="card-title text-center pb-0 fs-4">Tambah Staff.</h5>
                <p class="text-center small">Inputkan Email dan data anda!</p>
              </div>

              <form method="POST" class="row g-3 needs-validation" novalidate action="/register">
                @csrf
                <div class="col-12">
                  <label for="yourEmail" class="form-label">Username</label>
                  <input type="text" name="name" class="form-control" id="yourEmail" required>
                  <div class="invalid-feedback">Inputkan Username yang valid!</div>
                </div>

                <div class="col-12">
                  <label for="yourUsername" class="form-label">Email</label>
                  <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="email" name="email" class="form-control" id="yourUsername" required>
                    <div class="invalid-feedback">Inputkan email Anda!</div>
                  </div>
                </div>
                <div class="col-12">
                  <label for="yourPassword" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="yourPassword" required>
                  <div class="invalid-feedback">Inputkan password Anda!</div>
                </div>
                <div class="col-12">
                  <button class="btn btn-primary w-100" type="submit">Register</button>
                </div>
                <div class="col-12">
                  <p class="small mb-0">Kembali ? <a href="/dashboard">Dashboard.</a></p>
                </div>
              </form>

            </div>
          </div>

        </div>
      </div>
    </div>

  </section>
@endsection
