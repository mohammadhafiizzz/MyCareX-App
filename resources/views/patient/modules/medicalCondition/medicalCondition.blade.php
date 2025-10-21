<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Medical History</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-[Inter] bg-gray-100" x-data="{ isModalOpen: false }">

    @include('patient.components.header')

    @include('patient.components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <a href="{{ route('patient.myrecords') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 mb-3 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                Back to My Records
            </a>
            
            <h1 class="text-3xl font-bold text-gray-900">
                Medical Conditions
            </h1>
            <p class="mt-1 text-lg text-gray-700">A complete record of your diagnosed conditions.</p>
        </div>

        <section class="bg-white rounded-xl mb-7 shadow-sm border border-gray-200" aria-labelledby="conditions-heading">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h2 id="conditions-heading" class="text-xl font-semibold text-gray-900">
                        Medical Conditions
                    </h2>
                    <button 
                        type="button" 
                        @click="isModalOpen = true"
                        class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <i class="fas fa-plus" aria-hidden="true"></i>
                        Add Condition
                    </button>
                </div>
            </div>
            
            <div class="flow-root">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Condition</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Diagnosis Date</th>
                                <th scope="col" class="hidden sm:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Description</th>
                                <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Severity</th>
                                <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Condition Name</td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">Oct 15, 2020</td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">Notes on symptoms/management</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center font-medium text-red-700">
                                        <i class="fas fa-exclamation-circle mr-1.5" aria-hidden="true"></i> Severity
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Status</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-blue-600 hover:text-blue-900 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1">Edit</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Condition Name</td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">Oct 15, 2020</td>
                                <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">Notes on symptoms/management</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center font-medium text-red-700">
                                        <i class="fas fa-exclamation-circle mr-1.5" aria-hidden="true"></i> Severity
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Status</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-blue-600 hover:text-blue-900 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div 
        x-show="isModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-10 overflow-y-auto bg-gray-500 bg-opacity-75"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
        style="display: none;"
    >
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div
                x-show="isModalOpen"
                @click.outside="isModalOpen = false"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-xl shadow-xl"
            >
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold leading-6 text-gray-900" id="modal-title">
                        Add New Condition
                    </h3>
                    <button type="button" @click="isModalOpen = false" class="text-gray-400 hover:text-gray-600 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500">
                        <i class="fas fa-times" aria-hidden="true"></i>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                
                <form class="mt-6 space-y-6">
                    <div>
                        <label for="condition_name" class="block text-sm font-medium text-gray-700">Condition Name</label>
                        <input type="text" name="condition_name" id="condition_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="e.g., Hypertension">
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="condition_status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="condition_status" name="condition_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option>Active</option>
                                <option>Resolved</option>
                                <option>Inactive</option>
                            </select>
                        </div>
                        <div>
                            <label for="condition_onset_date" class="block text-sm font-medium text-gray-700">Date of Onset</label>
                            <input type="date" name="condition_onset_date" id="condition_onset_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="condition_notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                        <textarea id="condition_notes" name="condition_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="e.g., Self-reported, based on family history..."></textarea>
                    </div>

                    <div class="pt-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
                        <button type="button" @click="isModalOpen = false" class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            Cancel
                        </button>
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            Save Condition
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('patient.components.footer')

</body>
</html>