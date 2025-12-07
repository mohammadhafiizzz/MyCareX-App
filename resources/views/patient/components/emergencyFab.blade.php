{{-- Emergency Kit Floating Action Button --}}
<a href="{{ route('patient.emergency-kit.index') }}" 
   class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 md:bottom-8 md:right-8 h-11 sm:h-12 md:h-14 px-3 sm:px-4 md:px-5 bg-gradient-to-br from-red-600 to-red-800 rounded-full flex items-center justify-center shadow-lg shadow-red-600/40 hover:shadow-xl hover:shadow-red-600/50 cursor-pointer z-[999] transition-all duration-300 ease-out hover:scale-105 active:scale-95 animate-pulse-ring group print:hidden"
   aria-label="Open Emergency Kit"
   title="Emergency Kit">
    <div class="flex items-center gap-1.5 sm:gap-2 md:gap-2.5">
        <i class="fas fa-briefcase-medical text-white text-sm sm:text-base md:text-lg flex-shrink-0"></i>
        <span class="text-white text-xs sm:text-sm md:text-base font-semibold whitespace-nowrap tracking-wide">Emergency Kit</span>
    </div>
</a>