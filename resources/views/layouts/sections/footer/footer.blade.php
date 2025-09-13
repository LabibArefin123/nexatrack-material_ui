{{-- @php
    $containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
@endphp --}}

<!-- Footer -->
{{-- <footer class="content-footer footer bg-footer-theme">
    <div class="{{ $containerFooter }}">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body">
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>, made with <span class="text-danger"><i
                        class="tf-icons ri-heart-fill"></i></span> by <a
                    href="{{ !empty(config('variables.creatorUrl')) ? config('variables.creatorUrl') : '' }}"
                    target="_blank"
                    class="footer-link">{{ !empty(config('variables.creatorName')) ? config('variables.creatorName') : '' }}</a>
            </div>
            <div class="d-none d-lg-inline-block">
                <a href="{{ config('variables.licenseUrl') ? config('variables.licenseUrl') : '#' }}"
                    class="footer-link me-4" target="_blank">License</a>
                <a href="{{ config('variables.moreThemes') ? config('variables.moreThemes') : '#' }}" target="_blank"
                    class="footer-link me-4">More Themes</a>
                <a href="{{ config('variables.documentation') ? config('variables.documentation') . '/laravel-introduction.html' : '#' }}"
                    target="_blank" class="footer-link me-4">Documentation</a>
                <a href="{{ config('variables.support') ? config('variables.support') : '#' }}" target="_blank"
                    class="footer-link d-none d-sm-inline-block">Support</a>
            </div>
        </div>
    </div>
</footer> --}}
<!--/ Footer -->


<!--Start of /My Custom Footer -->
<footer class="main-footer">
    <div class="footer-left">
        © {{ date('Y') }}
        <a href="#" class="footer-link"><strong>NexaTrack.</strong></a>
        All rights reserved.
    </div>
    <div class="footer-right">
        Design and Developed by
        <a href="https://totalofftec.com" target="_blank" class="footer-link">
            <strong>TOTALOFFTEC</strong>
        </a>
    </div>
</footer>

<style>
    .main-footer {
        background-color: #f8f9fa;
        padding: 15px 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);

        display: flex;
        justify-content: space-between;
        /* left and right */
        align-items: center;
        flex-wrap: wrap;
        /* allows stacking on mobile */
    }

    .footer-left,
    .footer-right {
        font-size: 0.95rem;
        color: #333;
        margin: 5px 0;
        /* spacing on mobile */
    }

    .footer-link {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-link:hover {
        color: #ff9900;
    }

    /* Responsive: Mobile stacking */
    @media (max-width: 576px) {
        .main-footer {
            flex-direction: column;
            text-align: center;
            gap: 5px;
        }
    }
</style>

<!--End of /My Custom Footer -->
