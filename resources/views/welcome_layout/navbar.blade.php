<nav class="bg-white shadow py-4 px-6 relative z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('uploads/images/image.png') }}" alt="NexaTrack Logo" class="h-16 w-auto object-contain">
        </div>

        <!-- Hamburger Icon (Mobile Only) -->
        <div class="md:hidden">
            <button id="navToggle" class="text-gray-700 focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Menu -->
        <ul id="navMenu"
            class="hidden md:flex md:flex-row md:space-x-8 absolute md:static top-full left-0 w-full md:w-auto bg-white md:bg-transparent shadow md:shadow-none z-40 flex-col md:flex-row text-center md:text-left text-gray-700 font-medium">
            <li class="border-b md:border-none"><a href="{{ url('/') }}"
                    class="block px-6 py-3 hover:text-blue-600">Home</a></li>
            {{-- <li><a href="{{ route('contact') }}" class="block px-6 py-3 hover:text-blue-600">Contact</a></li> --}}
            <li><a href="#" class="block px-6 py-3 hover:text-blue-600">Contact</a></li>
        </ul>
    </div>
</nav>

<script>
    document.getElementById('navToggle').addEventListener('click', function() {
        const menu = document.getElementById('navMenu');
        menu.classList.toggle('hidden');
    });
</script>
