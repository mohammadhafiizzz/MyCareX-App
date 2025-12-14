<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medications Report - {{ $patient->first_name }} {{ $patient->last_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-gray-900 p-8 max-w-7xl mx-auto">
    
    <div class="border-b-4 border-blue-600 pb-5 mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">Medications Report</h1>
        <p class="text-gray-600 text-sm">Personal Health Record</p>
    </div>
    
    <div class="bg-gray-100 rounded-lg p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Patient Information</h2>
        <div class="grid grid-cols-2 gap-6">
            <div class="flex flex-col">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Full Name</span>
                <span class="text-sm text-gray-900 mt-1">{{ $patient->full_name }}</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</span>
                <span class="text-sm text-gray-900 mt-1">{{ $patient->email }}</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Date of Birth</span>
                <span class="text-sm text-gray-900 mt-1">{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') : 'Not provided' }}</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Report Generated</span>
                <span class="text-sm text-gray-900 mt-1">{{ $exportDate }}</span>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-50 border-l-4 border-blue-500 rounded p-5 mb-8">
        <h2 class="text-base font-semibold text-blue-900 mb-2">Summary</h2>
        <p class="text-sm text-blue-800">This report contains <strong>{{ $totalMedications }}</strong> medication{{ $totalMedications !== 1 ? 's' : '' }} on record.</p>
    </div>
    
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-gray-200">Medications</h2>
        
        @forelse ($medications as $medication)
            <div class="border border-gray-200 rounded-xl p-6 mb-6 bg-white">
                <div class="flex flex-wrap justify-between items-start gap-3 mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">{{ $medication['medication_name'] }}</h3>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $statusClass = match(strtolower($medication['status'])) {
                                'active' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                'on hold' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'completed' => 'bg-blue-100 text-blue-800 border-blue-300',
                                'discontinued' => 'bg-red-100 text-red-800 border-red-300',
                                default => 'bg-gray-100 text-gray-800 border-gray-300'
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide border {{ $statusClass }}">
                            {{ $medication['status'] }}
                        </span>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Dosage</div>
                        <div class="text-sm text-gray-800">{{ $medication['dosage'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Frequency</div>
                        <div class="text-sm text-gray-800">{{ $medication['frequency'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Start Date</div>
                        <div class="text-sm text-gray-800">{{ $medication['start_date'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">End Date</div>
                        <div class="text-sm text-gray-800">{{ $medication['end_date'] }}</div>
                    </div>
                </div>
                
                <div class="space-y-4">
                    @if ($medication['reason_for_med'] !== 'Not specified')
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Reason for Medication</div>
                            <div class="text-sm text-gray-800 leading-relaxed">{{ $medication['reason_for_med'] }}</div>
                        </div>
                    @endif
                    
                    @if ($medication['notes'] !== 'No additional notes')
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Notes & Instructions</div>
                            <div class="text-sm text-gray-800 leading-relaxed">{{ $medication['notes'] }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No Medications Found</h3>
                <p class="text-sm text-gray-600">There are currently no medications recorded in your health record.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-12 pt-6 border-t-2 border-gray-200 text-center text-gray-600 text-xs">
        <p class="font-semibold text-gray-800 mb-1">MyCareX - Personal Health Record System</p>
        <p class="mb-1">This is a confidential medical document. Please keep it secure.</p>
        <p>Generated on {{ $exportDate }}</p>
    </div>

</body>
</html>
