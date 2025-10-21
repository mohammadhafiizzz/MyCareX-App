<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - My Records</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    @include('patient.components.header')

    @include('patient.components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                My Records
            </h1>
            <p class="mt-1 text-lg text-gray-700">Manage your own medical records.</p>
        </div>

        <nav class="mb-10" aria-label="My Records Sections">
            <ul class="flex flex-wrap gap-3">
                <li>
                    <a href="{{ route('patient.medicalCondition') }}" class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200 text-sm font-medium text-gray-800 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <i class="fas fa-file-medical-alt text-blue-700" aria-hidden="true"></i>
                        <span>Conditions</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200 text-sm font-medium text-gray-800 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <i class="fas fa-flask text-blue-700" aria-hidden="true"></i>
                        <span>Lab Results</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200 text-sm font-medium text-gray-800 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <i class="fas fa-syringe text-blue-700" aria-hidden="true"></i>
                        <span>Vaccination</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200 text-sm font-medium text-gray-800 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <i class="fas fa-exclamation-triangle text-blue-700" aria-hidden="true"></i>
                        <span>Allergy</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200 text-sm font-medium text-gray-800 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <i class="fas fa-pills text-blue-700" aria-hidden="true"></i>
                        <span>Medication</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="space-y-6">

            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="history-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h2 id="history-heading" class="text-xl font-semibold text-gray-900">
                            Recent Medical Conditions
                        </h2>
                        <a href="{{ route('patient.medicalCondition') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            View all
                        </a>
                    </div>
                    <div class="mt-4 flow-root">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Condition</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Noted By</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Hypertension</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Dr. Evelyn Reed</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Oct 15, 2025</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Diabetes Mellitus Type 2</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Dr. Evelyn Reed</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Sep 02, 2025</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Seasonal Allergies</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Self-Reported</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Aug 20, 2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="labs-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h2 id="labs-heading" class="text-xl font-semibold text-gray-900">
                            Recent Lab Results
                        </h2>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            View all
                        </a>
                    </div>
                    <div class="mt-4 flow-root">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Test Name</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Complete Blood Count (CBC)</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Action Required</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Oct 18, 2025</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Lipid Panel</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">In Range</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Oct 18, 2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="vax-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h2 id="vax-heading" class="text-xl font-semibold text-gray-900">
                            Recent Vaccinations
                        </h2>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            View all
                        </a>
                    </div>
                    <div class="mt-4 flow-root">
                         <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Vaccine</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Dose</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">COVID-19 (Moderna)</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Booster</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Sep 30, 2025</td>
                                </tr>
                                 <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Influenza (Flu Shot)</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Annual</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Sep 30, 2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="allergy-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h2 id="allergy-heading" class="text-xl font-semibold text-gray-900">
                            Active Allergies
                        </h2>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            Manage
                        </a>
                    </div>
                    <div class="mt-4 flow-root">
                         <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Allergen</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Reaction</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Severity</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Penicillin</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Anaphylaxis</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center font-medium text-red-700">
                                             <i class="fas fa-exclamation-circle mr-1.5" aria-hidden="true"></i> Severe
                                        </span>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Peanuts</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Hives, Swelling</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                         <span class="inline-flex items-center font-medium text-red-700">
                                             <i class="fas fa-exclamation-circle mr-1.5" aria-hidden="true"></i> Severe
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Pollen</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Itchy Eyes, Sneezing</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                         <span class="inline-flex items-center font-medium text-yellow-700">
                                             <i class="fas fa-exclamation-triangle mr-1.5" aria-hidden="true"></i> Moderate
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="meds-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h2 id="meds-heading" class="text-xl font-semibold text-gray-900">
                            Current Medications
                        </h2>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            Manage
                        </a>
                    </div>
                    <div class="mt-4 flow-root">
                         <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Medication</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Dosage</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Lisinopril</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">10mg, 1x daily</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Refill Due</span>
                                    </td>
                                </tr>
                                 <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Metformin</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">500mg, 2x daily</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </div>

    @vite(['resources/js/main/patient/header.js'])
    @include('patient.components.footer')
</body>

</html>