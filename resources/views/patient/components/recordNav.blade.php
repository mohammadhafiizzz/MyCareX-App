{{-- Visual Navigation Grid --}}
<nav class="mb-10" aria-label="My Records Sections">
    {{-- Mobile: Horizontal Scroll --}}
    <div class="relative md:hidden">
        {{-- Scroll Indicator (Right) --}}
        <div class="absolute right-0 top-0 bottom-2 w-12 bg-gradient-to-l from-gray-50 to-transparent pointer-events-none z-10 flex items-center justify-end pr-2">
            <div class="w-6 h-6 rounded-full bg-white shadow-md flex items-center justify-center">
                <i class="fas fa-chevron-right text-xs text-gray-600" aria-hidden="true"></i>
            </div>
        </div>
        
        <div class="flex overflow-x-auto gap-3 pb-2 px-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden snap-x snap-mandatory scroll-smooth">
            {{-- Overview --}}
            <a href="{{ route('patient.myrecords') }}" 
                aria-label="Medical records overview{{ request()->routeIs('patient.myrecords') ? ' - current page' : '' }}"
                {{ request()->routeIs('patient.myrecords') ? 'aria-current="page"' : '' }}
                class="group relative flex-shrink-0 w-32 snap-start overflow-hidden rounded-xl border-2 transition-all {{ request()->routeIs('patient.myrecords') ? 'border-blue-600 bg-gradient-to-br from-blue-50 to-blue-100 shadow-md' : 'border-gray-200 bg-white' }}">
                <div class="p-4 text-center">
                    <div class="w-12 h-12 mx-auto mb-2 rounded-lg flex items-center justify-center transition-transform group-active:scale-95 {{ request()->routeIs('patient.myrecords') ? 'bg-blue-600' : 'bg-gray-100' }}">
                        <i class="fas fa-home text-lg {{ request()->routeIs('patient.myrecords') ? 'text-white' : 'text-blue-600' }}" aria-hidden="true"></i>
                    </div>
                    <span class="block text-xs font-semibold {{ request()->routeIs('patient.myrecords') ? 'text-blue-900' : 'text-gray-700' }}">
                        Overview
                    </span>
                </div>
            </a>

            {{-- Conditions --}}
            <a href="{{ route('patient.medicalCondition') }}" 
                aria-label="Medical conditions{{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? ' - current page' : '' }}"
                {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'aria-current="page"' : '' }}
                class="group relative flex-shrink-0 w-32 snap-start overflow-hidden rounded-xl border-2 transition-all {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'border-blue-600 bg-gradient-to-br from-blue-50 to-blue-100 shadow-md' : 'border-gray-200 bg-white' }}">
                <div class="p-4 text-center">
                    <div class="w-12 h-12 mx-auto mb-2 rounded-lg flex items-center justify-center transition-transform group-active:scale-95 {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'bg-blue-600' : 'bg-gray-100' }}">
                        <i class="fas fa-file-medical-alt text-lg {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'text-white' : 'text-blue-600' }}" aria-hidden="true"></i>
                    </div>
                    <span class="block text-xs font-semibold {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'text-blue-900' : 'text-gray-700' }}">
                        Conditions
                    </span>
                </div>
            </a>

            {{-- Medication --}}
            <a href="{{ route('patient.medication') }}" 
                aria-label="Medications{{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? ' - current page' : '' }}"
                {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'aria-current="page"' : '' }}
                class="group relative flex-shrink-0 w-32 snap-start overflow-hidden rounded-xl border-2 transition-all {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'border-blue-600 bg-gradient-to-br from-blue-50 to-blue-100 shadow-md' : 'border-gray-200 bg-white' }}">
                <div class="p-4 text-center">
                    <div class="w-12 h-12 mx-auto mb-2 rounded-lg flex items-center justify-center transition-transform group-active:scale-95 {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'bg-blue-600' : 'bg-gray-100' }}">
                        <i class="fas fa-pills text-lg {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'text-white' : 'text-blue-600' }}" aria-hidden="true"></i>
                    </div>
                    <span class="block text-xs font-semibold {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'text-blue-900' : 'text-gray-700' }}">
                        Medication
                    </span>
                </div>
            </a>

            {{-- Allergy --}}
            <a href="#" 
                aria-label="Allergies (coming soon)"
                class="group relative flex-shrink-0 w-32 snap-start overflow-hidden rounded-xl border-2 border-gray-200 bg-white transition-all">
                <div class="p-4 text-center">
                    <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-gray-100 flex items-center justify-center transition-transform group-active:scale-95">
                        <i class="fas fa-exclamation-triangle text-lg text-blue-600" aria-hidden="true"></i>
                    </div>
                    <span class="block text-xs font-semibold text-gray-700">
                        Allergy
                    </span>
                </div>
            </a>

            {{-- Vaccination --}}
            <a href="#" 
                aria-label="Vaccinations (coming soon)"
                class="group relative flex-shrink-0 w-32 snap-start overflow-hidden rounded-xl border-2 border-gray-200 bg-white transition-all">
                <div class="p-4 text-center">
                    <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-gray-100 flex items-center justify-center transition-transform group-active:scale-95">
                        <i class="fas fa-syringe text-lg text-blue-600" aria-hidden="true"></i>
                    </div>
                    <span class="block text-xs font-semibold text-gray-700">
                        Vaccination
                    </span>
                </div>
            </a>

            {{-- Lab Results --}}
            <a href="#" 
                aria-label="Lab results (coming soon)"
                class="group relative flex-shrink-0 w-32 snap-start overflow-hidden rounded-xl border-2 border-gray-200 bg-white transition-all">
                <div class="p-4 text-center">
                    <div class="w-12 h-12 mx-auto mb-2 rounded-lg bg-gray-100 flex items-center justify-center transition-transform group-active:scale-95">
                        <i class="fas fa-flask text-lg text-blue-600" aria-hidden="true"></i>
                    </div>
                    <span class="block text-xs font-semibold text-gray-700">
                        Lab Results
                    </span>
                </div>
            </a>
        </div>
    </div>

    {{-- Tablet & Desktop: Grid --}}
    <div class="hidden md:grid grid-cols-3 lg:grid-cols-6 gap-4">
        {{-- Overview --}}
        <a href="{{ route('patient.myrecords') }}" 
            aria-label="Medical records overview{{ request()->routeIs('patient.myrecords') ? ' - current page' : '' }}"
            {{ request()->routeIs('patient.myrecords') ? 'aria-current="page"' : '' }}
            class="group relative overflow-hidden rounded-xl border-2 transition-all hover:shadow-lg {{ request()->routeIs('patient.myrecords') ? 'border-blue-600 bg-gradient-to-br from-blue-50 to-blue-100' : 'border-gray-200 bg-white hover:border-blue-300' }}">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 {{ request()->routeIs('patient.myrecords') ? 'bg-blue-600' : 'bg-gray-100' }}">
                    <i class="fas fa-home text-xl {{ request()->routeIs('patient.myrecords') ? 'text-white' : 'text-blue-600' }}" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold {{ request()->routeIs('patient.myrecords') ? 'text-blue-900' : 'text-gray-700' }}">
                    Overview
                </span>
            </div>
        </a>

        {{-- Conditions --}}
        <a href="{{ route('patient.medicalCondition') }}" 
            aria-label="Medical conditions{{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? ' - current page' : '' }}"
            {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'aria-current="page"' : '' }}
            class="group relative overflow-hidden rounded-xl border-2 transition-all hover:shadow-lg {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'border-blue-600 bg-gradient-to-br from-blue-50 to-blue-100' : 'border-gray-200 bg-white hover:border-blue-300' }}">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'bg-blue-600' : 'bg-gray-100' }}">
                    <i class="fas fa-file-medical-alt text-xl {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'text-white' : 'text-blue-600' }}" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'text-blue-900' : 'text-gray-700' }}">
                    Conditions
                </span>
            </div>
        </a>

        {{-- Medication --}}
        <a href="{{ route('patient.medication') }}" 
            aria-label="Medications{{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? ' - current page' : '' }}"
            {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'aria-current="page"' : '' }}
            class="group relative overflow-hidden rounded-xl border-2 transition-all hover:shadow-lg {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'border-blue-600 bg-gradient-to-br from-blue-50 to-blue-100' : 'border-gray-200 bg-white hover:border-blue-300' }}">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'bg-blue-600' : 'bg-gray-100' }}">
                    <i class="fas fa-pills text-xl {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'text-white' : 'text-blue-600' }}" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'text-blue-900' : 'text-gray-700' }}">
                    Medication
                </span>
            </div>
        </a>

        {{-- Allergy --}}
        <a href="#" 
            aria-label="Allergies (coming soon)"
            class="group relative overflow-hidden rounded-xl border-2 border-gray-200 bg-white hover:border-blue-300 transition-all hover:shadow-lg">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-gray-100 flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="fas fa-exclamation-triangle text-xl text-blue-600" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold text-gray-700">
                    Allergy
                </span>
            </div>
        </a>

        {{-- Vaccination --}}
        <a href="#" 
            aria-label="Vaccinations (coming soon)"
            class="group relative overflow-hidden rounded-xl border-2 border-gray-200 bg-white hover:border-blue-300 transition-all hover:shadow-lg">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-gray-100 flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="fas fa-syringe text-xl text-blue-600" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold text-gray-700">
                    Vaccination
                </span>
            </div>
        </a>

        {{-- Lab Results --}}
        <a href="#" 
            aria-label="Lab results (coming soon)"
            class="group relative overflow-hidden rounded-xl border-2 border-gray-200 bg-white hover:border-blue-300 transition-all hover:shadow-lg">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-gray-100 flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="fas fa-flask text-xl text-blue-600" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold text-gray-700">
                    Lab Results
                </span>
            </div>
        </a>
    </div>
</nav>