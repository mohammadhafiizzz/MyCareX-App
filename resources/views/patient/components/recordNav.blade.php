{{-- Visual Navigation Grid --}}
<nav class="mb-10" aria-label="My Records Sections">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
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
            class="group relative overflow-hidden rounded-xl border-2 transition-all hover:shadow-lg {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'border-purple-600 bg-gradient-to-br from-purple-50 to-purple-100' : 'border-gray-200 bg-white hover:border-purple-300' }}">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'bg-purple-600' : 'bg-gray-100' }}">
                    <i class="fas fa-file-medical-alt text-xl {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'text-white' : 'text-purple-600' }}" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'text-purple-900' : 'text-gray-700' }}">
                    Conditions
                </span>
                @if($conditions->count() > 0)
                    <span class="absolute top-2 right-2 w-7 h-7 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg">
                        {{ $conditions->count() }}
                    </span>
                @endif
            </div>
        </a>

        {{-- Medication --}}
        <a href="{{ route('patient.medication') }}" 
            aria-label="Medications{{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? ' - current page' : '' }}"
            {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'aria-current="page"' : '' }}
            class="group relative overflow-hidden rounded-xl border-2 transition-all hover:shadow-lg {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'border-pink-600 bg-gradient-to-br from-pink-50 to-pink-100' : 'border-gray-200 bg-white hover:border-pink-300' }}">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'bg-pink-600' : 'bg-gray-100' }}">
                    <i class="fas fa-pills text-xl {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'text-white' : 'text-pink-600' }}" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'text-pink-900' : 'text-gray-700' }}">
                    Medication
                </span>
            </div>
        </a>

        {{-- Lab Results --}}
        <a href="#" 
            aria-label="Lab results (coming soon)"
            class="group relative overflow-hidden rounded-xl border-2 border-gray-200 bg-white hover:border-green-300 transition-all hover:shadow-lg">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-gray-100 flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="fas fa-flask text-xl text-green-600" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold text-gray-700">
                    Lab Results
                </span>
            </div>
        </a>

        {{-- Vaccination --}}
        <a href="#" 
            aria-label="Vaccinations (coming soon)"
            class="group relative overflow-hidden rounded-xl border-2 border-gray-200 bg-white hover:border-teal-300 transition-all hover:shadow-lg">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-gray-100 flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="fas fa-syringe text-xl text-teal-600" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold text-gray-700">
                    Vaccination
                </span>
            </div>
        </a>

        {{-- Allergy --}}
        <a href="#" 
            aria-label="Allergies (coming soon)"
            class="group relative overflow-hidden rounded-xl border-2 border-gray-200 bg-white hover:border-red-300 transition-all hover:shadow-lg">
            <div class="p-6 text-center">
                <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-gray-100 flex items-center justify-center transition-transform group-hover:scale-110">
                    <i class="fas fa-exclamation-triangle text-xl text-red-600" aria-hidden="true"></i>
                </div>
                <span class="block text-sm font-semibold text-gray-700">
                    Allergy
                </span>
            </div>
        </a>
    </div>
</nav>