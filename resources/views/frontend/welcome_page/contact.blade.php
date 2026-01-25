<section id="contact" class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">Get in Touch</h2>
            <p class="text-muted small">We’ll respond as quickly as possible.</p>
        </div>

        <div class="card shadow rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('contact.submit') }}" method="POST" class="row g-3">
                    @csrf

                    <!-- Row 1: Name + Company + Email -->
                    <div class="col-md-4">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Write your full name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Company Name <span class="text-danger">*</span></label>
                        <input type="text" name="company_name" value="{{ old('company_name') }}"
                            class="form-control @error('company_name') is-invalid @enderror"
                            placeholder="Write your company name">
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="Write your email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Row 2: Phone + Address -->
                    <div class="col-md-4">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            class="form-control @error('phone') is-invalid @enderror"
                            placeholder="Write your phone number">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" value="{{ old('address') }}"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="Write your address">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Row 3: Area + City + Post Code -->
                    <div class="col-md-4">
                        <label class="form-label">Area</label>
                        <input type="text" name="area" value="{{ old('area') }}"
                            class="form-control @error('area') is-invalid @enderror"
                            placeholder="Write your area, Ex = Dhanmondi">
                        @error('area')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <select name="city" class="form-select @error('city') is-invalid @enderror">
                            <option disabled {{ old('city') ? '' : 'selected' }}>Select city</option>
                            @foreach (['Dhaka', 'Chattogram', 'Khulna', 'Rajshahi', 'Sylhet', 'Barishal', 'Rangpur', 'Mymensingh'] as $city)
                                <option value="{{ $city }}" {{ old('city') === $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Post Code</label>
                        <input type="text" name="post_code" value="{{ old('post_code') }}"
                            class="form-control @error('post_code') is-invalid @enderror"
                            placeholder="Write your post code">
                        @error('post_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Row 4: Country + Note -->
                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <select name="country" class="form-select @error('country') is-invalid @enderror">
                            <option disabled {{ old('country') ? '' : 'selected' }}>Select country</option>
                            @foreach (['Bangladesh', 'India', 'United States', 'United Kingdom', 'Canada', 'Australia'] as $country)
                                <option value="{{ $country }}"
                                    {{ old('country') === $country ? 'selected' : '' }}>
                                    {{ $country }}
                                </option>
                            @endforeach
                        </select>
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Note</label>
                        <textarea name="note" rows="3" class="form-control @error('note') is-invalid @enderror"
                            placeholder="Write briefly about your requirements">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                            Submit Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Auto scroll to contact on error --}}
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                document.getElementById("contact")?.scrollIntoView({
                    behavior: "smooth"
                });
            });
        </script>
    @endif
</section>
