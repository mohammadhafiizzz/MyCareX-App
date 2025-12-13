<!-- Banner -->
<section class="relative h-80 bg-gray-900 overflow-hidden">
    {{-- Background Image with Overlay --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/my_records.png') }}" 
            alt="" 
            class="w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gray-900/40"></div>
    </div>
    
    <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">
                My Records
            </h1>
            <p class="text-lg md:text-xl text-gray-200">
                Manage your own medical records
            </p>
        </div>
    </div>
</section>