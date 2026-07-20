<div class="row">

    @php
        $contacts = [
            [
                'label' => 'Personal',
                'icon' => 'fa-user',
                'phone' => $patient->phone_1,
            ],
            [
                'label' => 'Alternative',
                'icon' => 'fa-phone',
                'phone' => $patient->phone_2,
            ],
            [
                'label' => 'Father',
                'icon' => 'fa-male',
                'phone' => $patient->phone_f_1,
            ],
            [
                'label' => 'Mother',
                'icon' => 'fa-female',
                'phone' => $patient->phone_m_1,
            ],
        ];
    @endphp


    @foreach ($contacts as $contact)
        <div class="col-md-6 col-xl-3 mb-3">

            <div class="contact-card">

                <div class="contact-card-icon">

                    <i class="fas {{ $contact['icon'] }}"></i>

                </div>

                <div class="contact-card-content">

                    <small>
                        {{ $contact['label'] }}
                    </small>

                    <span class="header-link contact-phone" data-phone="{{ $contact['phone'] }}">

                        {{ $contact['phone'] ?? 'N/A' }}

                    </span>

                </div>

            </div>

        </div>
    @endforeach

</div>
