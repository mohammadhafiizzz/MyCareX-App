<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Add Doctor</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('organisation.components.header')

    <!-- Sidebar -->
    @include('organisation.components.sidebar')

    <!-- Main Content -->
    <main class="lg:ml-68 mt-20 min-h-screen transition-all duration-300">
        <div class="bg-gray-50 min-h-screen py-6 px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Add New Doctor</h1>
                <p class="text-sm text-gray-500">Fill in the details below to register a new medical professional.</p>
            </div>

            <form id="add-doctor-form" method="POST" action="{{ route('organisation.doctor.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <!-- Section: Profile Photo -->
                    <div class="p-6 md:p-8 border-b border-gray-100 bg-gray-50/50">
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-center">
                            <label class="block text-sm font-bold text-gray-400 uppercase tracking-wider">Profile Photo</label>
                            <div class="mt-4 sm:mt-0 sm:col-span-2">
                                <div class="flex items-center gap-6">
                                    <div class="relative group w-24 h-24">
                                        <div id="image-preview-container" class="w-full h-full rounded-full overflow-hidden bg-white border-2 border-dashed border-gray-300 flex items-center justify-center transition-all group-hover:border-blue-400">
                                            <img id="imagePreview" src="" alt="Preview" class="hidden w-full h-full object-cover">
                                            <div id="upload-placeholder" class="text-center">
                                                <i class="fas fa-camera text-xl text-gray-400"></i>
                                            </div>
                                        </div>
                                        <input type="file" id="profile_image" name="profile_image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                                        <button type="button" id="remove-image" class="hidden absolute -top-1 -right-1 w-6 h-6 bg-red-500 text-white rounded-full shadow-sm flex items-center justify-center hover:bg-red-600 transition-colors">
                                            <i class="fas fa-times text-[10px]"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">JPG, PNG or GIF. Max 5MB.</p>
                                        <div id="image-error" class="hidden mt-2 text-xs text-red-600"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Personal Information -->
                    <div class="p-6 md:p-8 space-y-8">
                        <div class="space-y-6 sm:space-y-5">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-4">Personal Information</h3>
                            
                            <!-- Full Name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="full_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Full Name</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" id="full_name" name="full_name" required
                                        class="max-w-2xl block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm"
                                        placeholder="DR. MOHAMMAD BIN ABDULLAH"
                                        oninput="this.value = this.value.toUpperCase()">
                                    <p class="mt-1 text-xs text-red-500 hidden" id="error-full_name"></p>
                                </div>
                            </div>

                            <!-- IC Number -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="ic_number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">IC Number</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" id="ic_number" name="ic_number" required
                                        class="max-w-md block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm"
                                        placeholder="950101-01-5678">
                                    <p class="mt-1 text-xs text-red-500 hidden" id="error-ic_number"></p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Email Address</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="email" id="email" name="email" required
                                        class="max-w-md block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm"
                                        placeholder="doctor@mycarex.com">
                                    <p class="mt-1 text-xs text-red-500 hidden" id="error-email"></p>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Phone Number</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-md">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">+60</span>
                                        <input type="tel" id="phone_number" name="phone_number" required
                                            class="w-full pl-12 pr-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm"
                                            placeholder="12-3456789">
                                    </div>
                                    <p class="mt-1 text-xs text-red-500 hidden" id="error-phone_number"></p>
                                </div>
                            </div>

                            <!-- Specialisation -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="specialisation" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Specialisation</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-md">
                                        <select id="specialisation" name="specialisation"
                                            class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                            <option value="">Select Specialisation</option>
                                            <option value="General Practitioner">General Practitioner</option>
                                            <option value="Cardiologist">Cardiologist</option>
                                            <option value="Dermatologist">Dermatologist</option>
                                            <option value="Neurologist">Neurologist</option>
                                            <option value="Pediatrician">Pediatrician</option>
                                            <option value="Psychiatrist">Psychiatrist</option>
                                            <option value="Radiologist">Radiologist</option>
                                            <option value="Surgeon">Surgeon</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-xs text-red-500 hidden" id="error-specialisation"></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 sm:space-y-5 pt-8">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-4">Professional Credentials</h3>
                            
                            <!-- MMC Number -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="medical_license_number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Medical License Number (MMC)</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" id="medical_license_number" name="medical_license_number" required
                                        class="max-w-md block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm"
                                        placeholder="MMC-12345">
                                    <p class="mt-1 text-xs text-red-500 hidden" id="error-medical_license_number"></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 sm:space-y-5 pt-8">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-4">Security</h3>
                            
                            <!-- Password -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="password" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Password</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-md">
                                        <input type="password" id="password" name="password" required
                                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm"
                                            placeholder="••••••••">
                                        <button type="button" class="toggle-password-btn absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" data-target="password">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-red-500 hidden" id="error-password"></p>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Confirm Password</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-md">
                                        <input type="password" id="password_confirmation" name="password_confirmation" required
                                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm"
                                            placeholder="••••••••">
                                        <button type="button" class="toggle-password-btn absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" data-target="password_confirmation">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-red-500 hidden" id="error-password_confirmation"></p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <div class="text-sm font-bold text-gray-400 uppercase tracking-wider sm:mt-px sm:pt-2">Account Status</div>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <label class="flex items-center cursor-pointer group">
                                        <div class="relative">
                                            <input type="checkbox" id="active_status" name="active_status" value="1" checked class="sr-only peer">
                                            <div class="w-10 h-5 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 transition-colors"></div>
                                            <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full peer-checked:translate-x-5 transition-transform shadow-sm"></div>
                                        </div>
                                        <div class="ml-3">
                                            <span class="block text-sm font-semibold text-gray-900">Active Account</span>
                                            <span class="block text-xs text-gray-500">Allow immediate system access.</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                        <button type="submit" id="submit-btn"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-sm hover:bg-blue-700 transition-all duration-200">
                            <span>Register</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <!-- Javascript and Footer -->
    @include('organisation.components.footer')

    @vite(['resources/js/main/organisation/addDoctor.js'])

</body>

</html>