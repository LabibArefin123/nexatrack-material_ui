<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NexaTrack CRM - Smart Customer Relationship Management Software</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- ✅ Short Meta Description (≤160 chars) --}}
    <meta name="description"
        content="NexaTrack CRM software helps businesses manage customers, track sales, automate workflows, and boost growth with smart customer relationship management.">

    {{-- ✅ Keywords --}}
    <meta name="keywords"
        content="NexaTrack, CRM software, Customer Relationship Management, sales tracking, lead management, business automation, client management, SaaS CRM">

    {{-- ✅ Author --}}
    <meta name="author" content="NexaTrack">

    {{-- ✅ Canonical URL --}}
    <link rel="canonical" href="https://www.labib.work/nexatrack/">

    {{-- ✅ Open Graph Tags --}}
    <meta property="og:title" content="NexaTrack CRM - Smart Customer Relationship Management Software">
    <meta property="og:description"
        content="Simplify customer relationship management with NexaTrack CRM. Manage leads, track sales, and grow your business.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.labib.work/nexatrack/">
    <meta property="og:image" content="{{ asset('images/hero/nexatrack-banner.png') }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:updated_time" content="{{ now()->toIso8601String() }}">

    {{-- ✅ Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="NexaTrack CRM - Smart Customer Relationship Management Software">
    <meta name="twitter:description"
        content="Powerful CRM software to manage customers, automate tasks, and track sales. Boost business growth with NexaTrack.">
    <meta name="twitter:image" content="{{ asset('images/hero/nexatrack-banner.png') }}">
    {{-- ✅ Schema.org JSON-LD (Organization) --}}
    {{-- ✅ Schema.org JSON-LD (SoftwareApplication) --}}
    <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "NexaTrack CRM",
    "applicationCategory": "BusinessApplication",
    "operatingSystem": "Web, Cloud",
    "url": "https://www.labib.work/nexatrack/",
    "logo": "{{ asset('images/icon.JPG') }}",
    "description": "NexaTrack is a CRM software designed for customer relationship management, sales tracking, and workflow automation.",
    "publisher": {
      "@type": "Organization",
      "name": "NexaTrack",
      "url": "https://www.labib.work/nexatrack/"
    },
    "offers": {
      "@type": "Offer",
      "price": "0",
      "priceCurrency": "USD",
      "availability": "https://schema.org/InStock"
    },
    "sameAs": [
      "https://www.facebook.com/NexaTrackCRM",
      "https://www.linkedin.com/company/nexatrack"
    ]
  }
  </script>


    {{-- ✅ Favicon --}}
    <link rel="icon" href="{{ asset('images/icon22.png') }}" type="image/png">

    {{-- ✅ Last Modified / Freshness --}}
    <meta http-equiv="last-modified" content="{{ now()->toRfc7231String() }}">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">

    @include('welcome_layout.navbar')
    @include('welcome_layout.about')
    @include('welcome_layout.features')
    @include('welcome_layout.footer')

</body>

</html>
