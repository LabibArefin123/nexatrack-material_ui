<!-- Served Section -->
<section id="services" class="bg-white py-16 px-6 md:px-20">
    <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-900 dark:text-dark">
        We Are Serving For
    </h2>

    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @php
            $items = [
                ['img' => 'dgdp.png', 'label' => 'DGDP', 'url' => 'https://dgdp.gov.bd'],
                ['img' => 'army.png', 'label' => 'Bangladesh Army', 'url' => 'https://www.army.mil.bd'],
                ['img' => 'navy.png', 'label' => 'Bangladesh Navy', 'url' => 'https://www.navy.mil.bd'],
                ['img' => 'answervdp.png', 'label' => 'Bangladesh Ansar & VDP', 'url' => 'https://www.ansarvdp.gov.bd'],
                ['img' => 'image10.png', 'label' => 'Border Guard Bangladesh', 'url' => 'https://www.bgb.gov.bd'],
                ['img' => 'fireservice.png', 'label' => 'Fire Service', 'url' => 'https://www.bgb.gov.bd'],
                ['img' => 'image8.png', 'label' => 'BMTF', 'url' => 'https://www.bgb.gov.bd'],
                ['img' => 'image4.png', 'label' => 'Bangladesh Coastguard', 'url' => 'https://coastguard.gov.bd'],
            ];
        @endphp

        @foreach ($items as $item)
            <a href="{{ $item['url'] }}" target="_blank"
                class="flex flex-col items-center justify-center text-center border rounded-2xl p-5 shadow hover:shadow-md hover:scale-105 transition bg-white hover:bg-gray-50">
                <img src="{{ asset('images/we_served/' . $item['img']) }}" alt="{{ $item['label'] }}"
                    class="served-logo mb-4" />
                <p class="font-semibold text-gray-800 text-sm">{{ $item['label'] }}</p>
            </a>
        @endforeach
    </div>

    <style>
        .served-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
    </style>
</section>