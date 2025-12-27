<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download {{ $allergy['allergen'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-gray-900 p-8 max-w-7xl mx-auto">
    

    <div class="border-b-4 border-blue-600 pb-5 mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">Allergy: {{ $allergy['allergen'] }}</h1>
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
    
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-gray-200">{{ $allergy['allergen'] }}</h2>

        <div class="border border-gray-200 rounded-xl p-6 mb-6 bg-white page-break-avoid">
            <div class="flex flex-wrap justify-between items-start gap-3 mb-4">
                <div class="flex flex-wrap gap-2">
                    @php
                        $severityClass = match(strtolower($allergy['severity'])) {
                            'severe', 'life-threatening' => 'bg-red-50 text-red-700 border-red-200',
                            'moderate' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'mild' => 'bg-green-50 text-green-700 border-green-200',
                            default => 'bg-gray-50 text-gray-700 border-gray-200'
                        };
                        $statusClass = match(strtolower($allergy['status'])) {
                            'active' => 'bg-red-100 text-red-800 border-red-300',
                            'suspected' => 'bg-amber-100 text-amber-800 border-amber-300',
                            'resolved', 'inactive' => 'bg-green-100 text-green-800 border-green-300',
                            default => 'bg-gray-100 text-gray-800 border-gray-300'
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide border {{ $severityClass }}">
                        {{ $allergy['severity'] }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide border {{ $statusClass }}">
                        {{ $allergy['status'] }}
                    </span>
                </div>
            </div>
            
            <div class="space-y-4">
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Allergy Type</div>
                    <div class="text-sm text-gray-800">{{ $allergy['allergy_type'] }}</div>
                </div>

                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">First Observed Date</div>
                    <div class="text-sm text-gray-800">{{ $allergy['first_observed_date'] }}</div>
                </div>
                
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Reaction Description</div>
                    <div class="text-sm text-gray-800 leading-relaxed">{{ $allergy['reaction_desc'] }}</div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Record Created</div>
                        <div class="text-sm text-gray-800">{{ $allergy['created_at'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Last Updated</div>
                        <div class="text-sm text-gray-800">{{ $allergy['updated_at'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-12 pt-6 border-t-2 border-gray-200 text-center text-gray-600 text-xs page-break-avoid">
        <p class="font-semibold text-gray-800 mb-1">MyCareX - Personal Health Record System</p>
        <p class="mb-1">This is a confidential medical document. Please keep it secure.</p>
        <p>Generated on {{ $exportDate }}</p>
    </div>
</body>
</html>