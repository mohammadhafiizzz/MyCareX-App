<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Conditions Report - {{ $patient->full_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-gray-900 p-8 max-w-7xl mx-auto">
    

    <div class="border-b-4 border-blue-600 pb-5 mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">Medical Conditions Report</h1>
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
    
    <div class="bg-blue-50 border-l-4 border-blue-500 rounded p-5 mb-8 page-break-avoid">
        <h2 class="text-base font-semibold text-blue-900 mb-2">Summary</h2>
        <p class="text-sm text-blue-800">This report contains <strong>{{ $totalConditions }}</strong> medical condition{{ $totalConditions !== 1 ? 's' : '' }} on record.</p>
    </div>
    
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-gray-200">Medical Conditions</h2>
        
        @forelse ($conditions as $condition)
            <div class="border border-gray-200 rounded-xl p-6 mb-6 bg-white page-break-avoid">
                <div class="flex flex-wrap justify-between items-start gap-3 mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">{{ $condition['condition_name'] }}</h3>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $severityClass = match(strtolower($condition['severity'])) {
                                'severe' => 'bg-red-50 text-red-700 border-red-200',
                                'moderate' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'mild' => 'bg-green-50 text-green-700 border-green-200',
                                default => 'bg-gray-50 text-gray-700 border-gray-200'
                            };
                            $statusClass = match(strtolower($condition['status'])) {
                                'active' => 'bg-red-100 text-red-800 border-red-300',
                                'chronic' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'resolved' => 'bg-green-100 text-green-800 border-green-300',
                                default => 'bg-gray-100 text-gray-800 border-gray-300'
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide border {{ $severityClass }}">
                            {{ $condition['severity'] }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide border {{ $statusClass }}">
                            {{ $condition['status'] }}
                        </span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Diagnosis Date</div>
                        <div class="text-sm text-gray-800">{{ $condition['diagnosis_date'] }}</div>
                    </div>
                    
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Description</div>
                        <div class="text-sm text-gray-800 leading-relaxed">{{ $condition['description'] }}</div>
                    </div>
                    
                    @if ($condition['treatment'] !== 'No treatment information')
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Treatment</div>
                            <div class="text-sm text-gray-800 leading-relaxed">{{ $condition['treatment'] }}</div>
                        </div>
                    @endif
                    
                    @if ($condition['notes'] !== 'No additional notes')
                        <div>
                            <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Additional Notes</div>
                            <div class="text-sm text-gray-800 leading-relaxed">{{ $condition['notes'] }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">No Medical Conditions Found</h3>
                <p class="text-sm text-gray-600">There are currently no medical conditions recorded in your health record.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-12 pt-6 border-t-2 border-gray-200 text-center text-gray-600 text-xs page-break-avoid">
        <p class="font-semibold text-gray-800 mb-1">MyCareX - Personal Health Record System</p>
        <p class="mb-1">This is a confidential medical document. Please keep it secure.</p>
        <p>Generated on {{ $exportDate }}</p>
    </div>

    
</body>
</html>
</body>
</html>
