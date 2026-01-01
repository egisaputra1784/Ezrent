@push('css')
    <style>
        .footer {
            background: #fff;
            border-top: 1px solid #eee;
        }

        .footer strong {
            color: #4B49AC;
            /* warna primary Celestial */
        }
    </style>
@endpush

<footer class="footer py-3">
    <div class="container-fluid">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center small text-muted">
            <div>
                © {{ date('Y') }} <strong>EZRent</strong>. All rights reserved.
            </div>
            <div class="mt-2 mt-sm-0">
                Built with ❤️ by <span class="font-weight-bold">EZRent</span>
            </div>
        </div>
    </div>
</footer>
