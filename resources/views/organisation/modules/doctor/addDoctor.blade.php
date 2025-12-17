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
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-semibold text-gray-900">Add New Doctor</h1>
                <p class="text-sm text-gray-600 mt-1">Register a new doctor to your healthcare organisation</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-md shadow-xl max-w-5xl mx-auto p-6">
                <form id="add-doctor-form" method="POST" action="{{ route('organisation.doctor.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Error Message -->
                    <div id="form-error-message" class="hidden p-3 rounded-md bg-red-50 border border-red-200">
                        <div class="flex items-start gap-2">
                            <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                            <p class="text-sm text-red-700"></p>
                        </div>
                    </div>

                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="full_name" 
                            name="full_name" 
                            required 
                            maxlength="150"
                            class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('full_name') border-red-500 @enderror"
                            placeholder="Enter doctor's full name (as per IC/Passport)"
                            value="{{ old('full_name') }}"
                            oninput="this.value = this.value.toUpperCase()"
                        >
                        @error('full_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- IC Number & Email -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="ic_number" class="block text-sm font-medium text-gray-700">
                                IC Number <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="ic_number" 
                                name="ic_number" 
                                required 
                                maxlength="20"
                                class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('ic_number') border-red-500 @enderror"
                                placeholder="123456-78-9012"
                                value="{{ old('ic_number') }}"
                            >
                            @error('ic_number')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required 
                                maxlength="100"
                                class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('email') border-red-500 @enderror"
                                placeholder="doctor@example.com"
                                value="{{ old('email') }}"
                            >
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            id="phone_number" 
                            name="phone_number" 
                            required 
                            maxlength="15"
                            class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('phone_number') border-red-500 @enderror"
                            placeholder="01X-XXX XXXX"
                            value="{{ old('phone_number') }}"
                        >
                        @error('phone_number')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Medical License & Specialisation -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="medical_license_number" class="block text-sm font-medium text-gray-700">
                                Medical License Number <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="medical_license_number" 
                                name="medical_license_number" 
                                required 
                                maxlength="100"
                                class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('medical_license_number') border-red-500 @enderror"
                                placeholder="MMC Registration Number"
                                value="{{ old('medical_license_number') }}"
                            >
                            <p class="mt-1 text-xs text-gray-500">Malaysian Medical Council (MMC) registration number</p>
                            @error('medical_license_number')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="specialisation" class="block text-sm font-medium text-gray-700">
                                Specialisation
                            </label>
                            <select 
                                id="specialisation" 
                                name="specialisation"
                                class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('specialisation') border-red-500 @enderror"
                            >
                                <option value="">Select specialisation</option>
                                <option value="General Practitioner" {{ old('specialisation') == 'General Practitioner' ? 'selected' : '' }}>General Practitioner</option>
                                <option value="Cardiologist" {{ old('specialisation') == 'Cardiologist' ? 'selected' : '' }}>Cardiologist</option>
                                <option value="Dermatologist" {{ old('specialisation') == 'Dermatologist' ? 'selected' : '' }}>Dermatologist</option>
                                <option value="Neurologist" {{ old('specialisation') == 'Neurologist' ? 'selected' : '' }}>Neurologist</option>
                                <option value="Pediatrician" {{ old('specialisation') == 'Pediatrician' ? 'selected' : '' }}>Pediatrician</option>
                                <option value="Psychiatrist" {{ old('specialisation') == 'Psychiatrist' ? 'selected' : '' }}>Psychiatrist</option>
                                <option value="Radiologist" {{ old('specialisation') == 'Radiologist' ? 'selected' : '' }}>Radiologist</option>
                                <option value="Surgeon" {{ old('specialisation') == 'Surgeon' ? 'selected' : '' }}>Surgeon</option>
                            </select>
                            @error('specialisation')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password & Confirm Password -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    required
                                    class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm pr-10 @error('password') border-red-500 @enderror"
                                    placeholder="Create a strong password"
                                >
                                <button 
                                    type="button"
                                    onclick="togglePasswordVisibility('password', 'togglePasswordIcon1')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                >
                                    <i class="fas fa-eye" id="togglePasswordIcon1"></i>
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Minimum 8 characters with letters and numbers</p>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Confirm Password <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    required
                                    class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm pr-10"
                                    placeholder="Confirm your password"
                                >
                                <button 
                                    type="button"
                                    onclick="togglePasswordVisibility('password_confirmation', 'togglePasswordIcon2')"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                >
                                    <i class="fas fa-eye" id="togglePasswordIcon2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Image Upload -->
                    <div>
                        <label for="profile_image" class="block text-sm font-medium text-gray-700">
                            Profile Image (Optional)
                        </label>
                        <div class="mt-1">
                            <input 
                                type="file" 
                                id="profile_image" 
                                name="profile_image" 
                                accept="image/jpeg,image/png,image/jpg"
                                class="hidden"
                            >
                            <div id="fileDropArea" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition">
                                <div id="fileDropContent">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600 font-medium mb-1">Click to browse or drag and drop</p>
                                    <p class="text-xs text-gray-500">JPG, PNG (Max 2MB)</p>
                                </div>
                                <div id="filePreview" class="hidden">
                                    <img id="imagePreview" src="" alt="Preview" class="mx-auto mb-2 h-32 w-32 object-cover rounded-lg">
                                    <p id="fileName" class="text-sm text-gray-900 font-medium mb-1"></p>
                                    <p id="fileSize" class="text-xs text-gray-500 mb-2"></p>
                                    <button type="button" id="removeFile" class="text-xs text-red-600 hover:text-red-700 font-medium">
                                        <i class="fas fa-times-circle"></i>
                                        Remove file
                                    </button>
                                </div>
                            </div>
                            @error('profile_image')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div id="uploadError" class="hidden mt-2 p-2 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
                                <p id="uploadErrorMessage" class="text-xs text-red-700"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Status -->
                    <div>
                        <label class="flex items-center">
                            <input 
                                type="checkbox" 
                                id="active_status" 
                                name="active_status" 
                                value="1" 
                                checked
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            >
                            <span class="ml-2 text-sm text-gray-700">Active account (allow doctor to access the system immediately)</span>
                        </label>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
                        <button 
                            type="submit" 
                            id="save-doctor-button"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                        >
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span id="save-button-text">Add Doctor</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Javascript and Footer -->
    @include('organisation.components.footer')

    @vite(['resources/js/main/organisation/addDoctor.js'])

</body>

</html>