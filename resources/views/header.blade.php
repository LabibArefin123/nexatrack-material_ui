<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex items-center justify-between px-4 py-3">
        <!-- Logo -->
        <a href="#" class="flex items-center">
            <img src="{{ asset('uploads/images/logo2.png') }}" alt="NexaTrack Logo" class="h-10 w-auto">
        </a>

        <!-- Mobile Menu Button -->
        <button id="menu-toggle" class="lg:hidden text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>

        <!-- Nav Links -->
        <div id="menu" class="hidden lg:flex lg:items-center lg:space-x-8">
            <a href="#about" class="text-gray-700 hover:text-blue-600">About</a>
            <a href="#features" class="text-gray-700 hover:text-blue-600">Features</a>
            <a href="#services" class="text-gray-700 hover:text-blue-600">Services</a>
            <a href="#contact" class="text-gray-700 hover:text-blue-600">Contact</a>
        </div>

        <!-- Login Button -->
        <div class="hidden lg:block">
            <a href="{{ route('login') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Login
            </a>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden lg:hidden px-4 pb-4 space-y-2">
        <a href="#about" class="block text-gray-700 hover:text-blue-600">About</a>
        <a href="#features" class="block text-gray-700 hover:text-blue-600">Features</a>
        <a href="#services" class="block text-gray-700 hover:text-blue-600">Services</a>
        <a href="#contact" class="block text-gray-700 hover:text-blue-600">Contact</a>
        <a href="{{ route('login') }}"
            class="block px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition text-center">
            Login
        </a>
    </div>
</nav>

<script>
    document.getElementById("menu-toggle").addEventListener("click", function() {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    });
</script>
