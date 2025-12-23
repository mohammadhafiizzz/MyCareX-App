<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Provider</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('organisation.components.header')

    <!-- Sidebar -->
    @include('organisation.components.sidebar')

    <!-- Main Content -->
    <main class="ml-68 mt-20 min-h-screen">
        <div class="py-8 px-6 max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Add New Doctor</h1>
                <p class="text-gray-500 mt-2">Register a new medical professional to your healthcare organisation.</p>
            </div>

            <form id="add-doctor-form" method="POST" action="{{ route('organisation.doctor.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Profile Image -->
                    <div class="lg:col-span-1">
                        <div class="bg-white/80 backdrop-blur-md border border-white/20 rounded-3xl shadow-xl p-8 sticky top-28">
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-gray-900 mb-6">Profile Photo</h3>
                                
                                <div class="relative group mx-auto w-48 h-48">
                                    <div id="image-preview-container" class="w-full h-full rounded-3xl overflow-hidden bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center transition-all group-hover:border-blue-400">
                                        <img id="imagePreview" src="" alt="Preview" class="hidden w-full h-full object-cover">
                                        <div id="upload-placeholder" class="text-center p-4">
                                            <i class="fas fa-camera text-4xl text-gray-400 mb-2"></i>
                                            <p class="text-xs text-gray-500">Click to upload photo</p>
                                        </div>
                                    </div>
                                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                                    
                                    <button type="button" id="remove-image" class="hidden absolute -top-2 -right-2 w-8 h-8 bg-red-500 text-white rounded-full shadow-lg flex items-center justify-center hover:bg-red-600 transition-colors">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </div>
                                
                                <div class="mt-6 space-y-2">
                                    <p class="text-xs text-gray-500">Allowed formats: JPG, PNG, GIF</p>
                                    <p class="text-xs text-gray-500">Maximum size: 2MB</p>
                                </div>

                                <div id="image-error" class="hidden mt-4 p-3 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-600">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Form Details -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Personal Information -->
                        <div class="bg-white/80 backdrop-blur-md border border-white/20 rounded-3xl shadow-xl p-8">
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-10 h-10 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Personal Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Full Name (as per IC/Passport)</label>
                                    <input type="text" id="full_name" name="full_name" required
                                        class="w-full px-5 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none"
                                        placeholder="DR. MOHAMMAD BIN ABDULLAH"
                                        oninput="this.value = this.value.toUpperCase()">
                                    <p class="mt-1.5 ml-1 text-xs text-red-500 hidden" id="error-full_name"></p>
                                </div>

                                <div>
                                    <label for="ic_number" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">IC Number</label>
                                    <input type="text" id="ic_number" name="ic_number" required
                                        class="w-full px-5 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none"
                                        placeholder="950101-01-5678">
                                    <p class="mt-1.5 ml-1 text-xs text-red-500 hidden" id="error-ic_number"></p>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Email Address</label>
                                    <input type="email" id="email" name="email" required
                                        class="w-full px-5 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none"
                                        placeholder="doctor@mycarex.com">
                                    <p class="mt-1.5 ml-1 text-xs text-red-500 hidden" id="error-email"></p>
                                </div>

                                <div>
                                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Phone Number</label>
                                    <div class="relative">
                                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 font-medium">+60</span>
                                        <input type="tel" id="phone_number" name="phone_number" required
                                            class="w-full pl-14 pr-5 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none"
                                            placeholder="12-3456789">
                                    </div>
                                    <p class="mt-1.5 ml-1 text-xs text-red-500 hidden" id="error-phone_number"></p>
                                </div>

                                <div>
                                    <label for="specialisation" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Specialisation</label>
                                    <select id="specialisation" name="specialisation"
                                        class="w-full px-5 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none appearance-none">
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
                                    <p class="mt-1.5 ml-1 text-xs text-red-500 hidden" id="error-specialisation"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Professional Credentials -->
                        <div class="bg-white/80 backdrop-blur-md border border-white/20 rounded-3xl shadow-xl p-8">
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-10 h-10 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Professional Credentials</h3>
                            </div>

                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="medical_license_number" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Medical License Number (MMC)</label>
                                    <input type="text" id="medical_license_number" name="medical_license_number" required
                                        class="w-full px-5 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none"
                                        placeholder="MMC-12345">
                                    <p class="mt-1.5 ml-1 text-xs text-red-500 hidden" id="error-medical_license_number"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Security -->
                        <div class="bg-white/80 backdrop-blur-md border border-white/20 rounded-3xl shadow-xl p-8">
                            <div class="flex items-center gap-3 mb-8">
                                <div class="w-10 h-10 rounded-2xl bg-green-50 flex items-center justify-center text-green-600">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Security</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Password</label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" required
                                            class="w-full px-5 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none"
                                            placeholder="••••••••">
                                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div id="password-strength" class="mt-3 space-y-2 hidden">
                                        <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                            <div id="strength-bar" class="h-full w-0 transition-all duration-500"></div>
                                        </div>
                                        <p id="strength-text" class="text-[10px] font-medium uppercase tracking-wider"></p>
                                    </div>
                                    <p class="mt-1.5 ml-1 text-xs text-red-500 hidden" id="error-password"></p>
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2 ml-1">Confirm Password</label>
                                    <div class="relative">
                                        <input type="password" id="password_confirmation" name="password_confirmation" required
                                            class="w-full px-5 py-4 bg-gray-50/50 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none"
                                            placeholder="••••••••">
                                        <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1.5 ml-1 text-xs text-red-500 hidden" id="error-password_confirmation"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Account Status -->
                        <div class="bg-white/80 backdrop-blur-md border border-white/20 rounded-3xl shadow-xl p-8">
                            <label class="flex items-center cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" id="active_status" name="active_status" value="1" checked class="sr-only peer">
                                    <div class="w-12 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-500 transition-colors"></div>
                                    <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full peer-checked:translate-x-6 transition-transform"></div>
                                </div>
                                <div class="ml-4">
                                    <span class="block text-sm font-bold text-gray-900">Active Account</span>
                                    <span class="block text-xs text-gray-500">Allow doctor to access the system immediately after registration.</span>
                                </div>
                            </label>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="{{ route('organisation.dashboard') }}" 
                                class="px-8 py-4 text-sm font-bold text-gray-600 hover:text-gray-900 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" id="submit-btn"
                                class="px-10 py-4 bg-blue-600 text-white text-sm font-bold rounded-2xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 hover:shadow-blue-500/40 transition-all flex items-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span>Register Doctor</span>
                                <i class="fas fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>

    <!-- Javascript and Footer -->
    @include('organisation.components.footer')

    @vite(['resources/js/main/organisation/addDoctor.js'])

</body>

</html>