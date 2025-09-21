<footer class="main-footer">
    <div class="footer-left">
        &copy;
        <a href="#" target="_blank" class="footer-link fw-semibold">
            NexaTrack
        </a>
        All rights reserved.
    </div>
    <div class="footer-right">
        Developed by
        <a href="https://totalofftec.com" target="_blank" class="footer-link fw-semibold">
            <span class="onstage-text">total<span class="off-highlight">offtec</span></span>
        </a>
    </div>
</footer>

<style>
    /* Custom font */
    @font-face {
        font-family: 'OnStage';
        src: url('fonts/OnStage_Regular.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

    .onstage-text {
        font-family: 'OnStage', sans-serif;
        color: #ff9900;
    }

    .off-highlight {
        color: #B2BEB5 !important;
    }

    /* Footer styles */
    .main-footer {
        background-color: #f8f9fa;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        font-size: 0.9rem;
        color: #333;
        border-top: 1px solid #dee2e6;
    }

    .footer-left,
    .footer-right {
        margin: 5px 0;
    }

    .footer-link {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer-link:hover {
        color: #ff9900;
    }

    /* Mobile: center everything */
    @media (max-width: 576px) {
        .main-footer {
            flex-direction: column;
            text-align: center;
            gap: 5px;
        }
    }
</style>
