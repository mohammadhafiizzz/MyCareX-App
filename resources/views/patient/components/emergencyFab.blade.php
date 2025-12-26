{{-- Emergency Kit Floating Action Button --}}
<a href="{{ route('patient.emergency-kit.index') }}" 
   class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 md:bottom-8 md:right-8 h-11 sm:h-12 md:h-14 px-3 sm:px-4 md:px-5 inline-flex items-center cursor-pointer gap-2 py-2.5 bg-gradient-to-br from-red-500/90 to-red-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-full shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40 hover:from-red-500 hover:to-red-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50 focus-visible:ring-offset-0 group print:hidden"
   aria-label="Open Emergency Kit"
   title="Emergency Kit">
    <div class="flex items-center gap-1.5 sm:gap-2 md:gap-2.5">
        <i class="fas fa-briefcase-medical text-white text-sm sm:text-base md:text-lg flex-shrink-0"></i>
        <span class="text-white text-xs sm:text-sm md:text-base font-semibold whitespace-nowrap tracking-wide">Emergency Kit</span>
    </div>
</a>