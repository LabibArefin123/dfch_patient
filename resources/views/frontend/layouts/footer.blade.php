<footer class="main-footer d-flex justify-content-between align-items-center px-4 py-3 bg-light shadow-sm">
    <div>
        © {{ date('Y') }}
        <a href="https://fazlulhaquehospital.com/" target="_blank" class="dev-link fw-bold text-decoration-none">
            <strong> {{ $orgLogo }}.</strong>
        </a> All rights reserved.
    </div>

    <div class="footer-right">
        Design and Developed by
        <a href="https://www.labib.work" target="_blank"
            class="dev-link fw-bold text-decoration-none ms-1 totalofftec-link">
            Labib Arefin
        </a>
    </div>
</footer>

<style>
    @font-face {
        font-family: 'OnStage';
        src: url('{{ asset('fonts/OnStage_Regular.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    .dev-link {
        padding: 1px 1px;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        color: #000;
        text-decoration: none;
    }

    .dev-link:hover {
        background-color: #ff6b6b;
        color: #fff;
    }

    /* Right side TOTALOFFTEC custom styles */
    .totalofftec-link {
        font-family: 'OnStage', sans-serif;
        font-size: 16px;
        /* small text */
        font-weight: bold;
        gap: 0;
    }

    .totalofftec-link .total {
        color: #ff6b6b;
    }

    .totalofftec-link .offtec {
        color: #d9d9d9;
    }
</style>
