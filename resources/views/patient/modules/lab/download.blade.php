<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download {{ $labTest['test_name'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans text-gray-900 p-8 max-w-7xl mx-auto">

    <div class="border-b-4 border-blue-600 pb-5 mb-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-2">Lab Test: {{ $labTest['test_name'] }}</h1>
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
        <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-gray-200">{{ $labTest['test_name'] }}</h2>
        
        <div class="border border-gray-200 rounded-xl p-6 mb-6 bg-white page-break-avoid">
            
            <div class="space-y-4">
                @if ($labTest['test_category'] !== 'Not specified')
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Test Category</div>
                        <div class="text-sm text-gray-800">{{ $labTest['test_category'] }}</div>
                    </div>
                @endif
                
                <div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Test Date</div>
                    <div class="text-sm text-gray-800">{{ $labTest['test_date'] }}</div>
                </div>
                
                @if ($labTest['facility_name'] !== 'Not specified')
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Facility Name</div>
                        <div class="text-sm text-gray-800">{{ $labTest['facility_name'] }}</div>
                    </div>
                @endif
                
                @if ($labTest['notes'] !== 'No additional notes')
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Additional Notes</div>
                        <div class="text-sm text-gray-800 leading-relaxed">{{ $labTest['notes'] }}</div>
                    </div>
                @endif
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
