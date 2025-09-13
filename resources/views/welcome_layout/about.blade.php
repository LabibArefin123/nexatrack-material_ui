<style>
    /* ===== About Section ===== */
    #about {
        padding: 5rem 2rem;
        background-color: #ffffff;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    /* Section Header */
    #about h2 {
        font-size: 3rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 1rem;
        text-align: center;
    }

    /* Intro paragraph */
    #about .intro {
        font-size: 1.25rem;
        color: #6c757d;
        text-align: center;
        margin-bottom: 3rem;
    }

    /* Container padding */
    #about .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Row: Image + Text */
    #about .row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 2rem;
    }

    /* Image column */
    #about .col-image {
        flex: 1;
        min-width: 300px;
    }

    #about .col-image img {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 0.5rem;
        transition: transform 0.3s ease;
    }

    #about .col-image img:hover {
        transform: scale(1.05);
    }

    /* Text column */
    #about .col-text {
        flex: 1;
        min-width: 250px;
    }

    #about .col-text p {
        font-size: 1rem;
        line-height: 1.8;
        margin-bottom: 1.5rem;
        color: #495057;
        text-align: justify;
    }

    #about .col-text strong {
        color: #212529;
    }

    /* Full-width image helper */
    .full-width-img {
        width: 100%;
        height: auto;
        display: block;
    }

    /* ===== Responsive: Tablets & Mobile ===== */
    @media (max-width: 992px) {
        #about .row {
            flex-direction: column;
            text-align: center;
        }

        #about .col-text p {
            text-align: left;
        }

        #about .col-image,
        #about .col-text {
            min-width: 100%;
        }

        #about h2 {
            font-size: 2.2rem;
        }

        #about .intro {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        #about {
            padding: 3rem 1rem;
        }

        #about h2 {
            font-size: 1.8rem;
        }

        #about .intro {
            font-size: 1rem;
        }

        #about .col-text p {
            font-size: 0.95rem;
        }
    }
</style>
<section id="about" class="content">
    <div class="container" data-aos="fade-up">
        <!-- Header -->
        <h2>About Us</h2>
        <p class="intro">
            Secure. Smart. Simplified. NexaTrack is your trusted solution for modern credential management.
        </p>

        <!-- Row: Image + Text -->
        <div class="row">
            <!-- Image Column -->
            <div class="col-image">
                <img src="{{ asset('uploads/images/welcome_page/about/about.png') }}"
                    alt="NexaTrack - Credential Management System" class="full-width-img">
            </div>

            <!-- Text Column -->
            <div class="col-text">
                <p>
                    <strong>NexaTrack</strong> is engineered to streamline and secure the way organizations manage
                    credentials, access rights, and sensitive identity data. Built for simplicity and precision,
                    NexaTrack provides a centralized platform to handle everything from employee credentials to
                    third-party access permissions.
                </p>
                <p>
                    With features like encrypted storage, role-based access control, detailed audit logs, and real-time
                    access monitoring, <strong>NexaTrack</strong> helps teams maintain compliance, reduce security
                    risks, and operate with complete control over credential lifecycles. Whether you're managing
                    digital certificates, physical access badges, or user roles across systems, NexaTrack is flexible
                    enough to scale with your organization’s needs—making secure credential governance effortless and
                    reliable.
                </p>
            </div>
        </div>
    </div>
</section>
