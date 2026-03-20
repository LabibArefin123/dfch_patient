  {{-- RIGHT : LOGIN --}}
  <div class="login-panel">
      <div class="text-center mb-4">
          <h4 class="fw-bold">Secure Login</h4>
          <p class="text-muted">Hospital Management System</p>
      </div>

      <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3">
              <label class="form-label fw-semibold">Email or Username</label>
              <input type="text" name="login"
                  class="form-control form-control-lg @error('login') is-invalid @enderror"
                  placeholder="Enter email or username">
          </div>

          <div class="mb-4">
              <label for="password" class="form-label fw-semibold"></label>
              <input id="password" type="password"
                  class="form-control form-control-lg rounded-3 shadow-sm @error('login') is-invalid @enderror"
                  name="password" placeholder="Enter your password" required>

              {{-- Show password errors only if maintenance is OFF --}}
              @error('login')
                  @unless (session('maintenance'))
                      <div class="invalid-feedback d-block mt-2">
                          <strong>{{ $message }}</strong>
                      </div>
                  @endunless
              @enderror

              {{-- Maintenance Message --}}
              @if (session('maintenance'))
                  <div class="alert alert-warning mt-3 mb-0 py-2 px-3 rounded-3">
                      <i class="fas fa-tools mr-1"></i>
                      {{ session('maintenance') }}
                  </div>
              @endif

              {{-- Banned Message --}}
              @if (session('banned'))
                  <div class="alert alert-danger mt-3 mb-0 py-2 px-3 rounded-3">
                      <i class="fas fa-ban mr-1"></i>
                      {{ session('banned') }}
                  </div>
              @endif
          </div>
          @if ($errors->has('login'))
              <div class="alert alert-danger mt-2">
                  {{ $errors->first('login') }}
              </div>
          @endif
          <button class="btn login-btn w-100 py-2 rounded-pill mt-3">
              Login
          </button>

          <div class="text-center mt-3">
              <a href="{{ route('password.request') }}" id="forgotPasswordLink" class="text-decoration-none dev-link">
                  Forgot Password?
              </a>
          </div>
          <hr class="my-4">

          <div class="text-center">
              <a href="javascript:void(0)" id="openProblemBtn" class="text-decoration-none dev-link fw-semibold">
                  ⚠ Facing a system problem?
              </a>
              <p class="text-muted small mt-1">
                  Let us know — our technical team will take care of it.
              </p>
          </div>
      </form>
  </div>
