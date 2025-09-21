<section id="features" class="content">
    <div class="container">
        <h2>Key Features</h2>
        <div class="features-grid">
            <a href="#instant-access">
                <div class="feature-box bg-primary text-white">
                    <i class="fas fa-key fa-3x"></i>
                    <h5>Instant Credential Access</h5>
                    <p>Quickly retrieve and manage credentials with a seamless, user-friendly interface built for speed.
                    </p>
                </div>
            </a>
            <a href="#data-security">
                <div class="feature-box bg-success text-white">
                    <i class="fas fa-lock fa-3x"></i>
                    <h5>Enterprise-Grade Security</h5>
                    <p>All credentials are stored with advanced encryption and access controls to protect your
                        organization.</p>
                </div>
            </a>
            <a href="#access-control">
                <div class="feature-box bg-warning text-dark">
                    <i class="fas fa-user-shield fa-3x"></i>
                    <h5>Role-Based Access</h5>
                    <p>Assign access based on user roles and ensure only authorized personnel can view or edit
                        credentials.</p>
                </div>
            </a>
            <a href="#audit-logs">
                <div class="feature-box bg-danger text-white">
                    <i class="fas fa-clipboard-list fa-3x"></i>
                    <h5>Comprehensive Audit Logs</h5>
                    <p>Track every access, update, and deletion with detailed logs for compliance and oversight.</p>
                </div>
            </a>
            <a href="#custom-policies">
                <div class="feature-box bg-info text-white">
                    <i class="fas fa-sliders-h fa-3x"></i>
                    <h5>Custom Access Policies</h5>
                    <p>Define rules for credential expiration, renewal reminders, and approval-based access workflows.
                    </p>
                </div>
            </a>
            <a href="#support">
                <div class="feature-box bg-secondary text-white">
                    <i class="fas fa-headset fa-3x"></i>
                    <h5>24/7 Expert Support</h5>
                    <p>Our dedicated team is available around the clock to assist with any issues or questions you have.
                    </p>
                </div>
            </a>
        </div>
    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
</section>

<style>
    /* ===== Features Section ===== */
    #features {
        padding: 5rem 1.5rem;
        background-color: #f8f9fa;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        text-align: center;
    }

    /* Section Header */
    #features h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 2.5rem;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        max-width: 1000px;
        margin: 0 auto;
        justify-content: center;
        /* center all items horizontally */
        align-items: stretch;
    }


    /* Feature Box */
    .feature-box {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        text-align: center;
        padding: 2rem;
        border-radius: 0.75rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        height: 100%;
        min-height: 320px;
        box-sizing: border-box;
    }

    .feature-box i {
        margin-bottom: 1rem;
        transition: transform 0.3s ease;
    }

    .feature-box h5 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .feature-box p {
        font-size: 1rem;
        line-height: 1.5;
        color: #f8f9fa;
    }

    /* Hover effects */
    .feature-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .feature-box:hover i {
        transform: scale(1.2);
    }

    /* Background colors */
    .bg-primary {
        background-color: #007bff !important;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    .bg-info {
        background-color: #17a2b8 !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }

    /* ===== Responsive: Tablets ===== */
    @media (max-width: 992px) {
        .features-grid {
            grid-template-columns: repeat(2, 1fr);
            max-width: 800px;
            justify-items: center;
        }
    }

    /* ===== Responsive: Mobile ===== */
    @media (max-width: 576px) {
        .features-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
            max-width: 100%;
        }

        .feature-box {
            padding: 1rem;
            min-height: auto;
        }

        #features h2 {
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }

        .feature-box i {
            font-size: 1.5rem !important;
            margin-bottom: 0.5rem;
        }

        .feature-box h5 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .feature-box p {
            font-size: 0.85rem;
        }

        .features-grid a {
            text-decoration: none;
            color: inherit;
            pointer-events: none;
        }
    }
</style>
