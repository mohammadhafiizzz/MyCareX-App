<!-- Footer -->
<footer class="bg-sky-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- About MyCareX -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                    </div>
                    <div class="text-xl font-bold">MyCareX</div>
                </div>
                <p class="text-gray-300 text-sm leading-relaxed">
                    Making personal healthcare records secure, accessible, and fully manageable for every Malaysian.
                </p>
                <div class="space-y-2">
                    <div class="inline-flex items-center space-x-2 bg-green-800 px-3 py-1 rounded-full text-xs">
                        <i class="fas fa-shield-alt"></i>
                        <span>PDPA 2010 Compliant</span>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('patient.dashboard') }}"
                            class="text-gray-300 hover:text-white transition-colors text-sm">Dashboard</a></li>
                    <li><a href="{{ route('patient.myrecords') }}" class="text-gray-300 hover:text-white transition-colors text-sm">My Records</a>
                    </li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Access & Permissions</a>
                    </li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Help Center</a>
                    </li>
                </ul>
            </div>

            <!-- Support -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Legal & Support</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Privacy Policy</a>
                    </li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Terms of
                            Service</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Help Center</a>
                    </li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">User Guide</a></li>
                    <li><a href="mailto:support@mycarex.gov.my"
                            class="text-gray-300 hover:text-white transition-colors text-sm">Contact Support</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Accessibility</a>
                    </li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Contact Information</h3>
                <div class="space-y-3 text-sm">
                    <p class="font-medium">Ministry of Health Malaysia</p>
                    <p class="text-gray-300 flex items-start space-x-2">
                        <i class="fas fa-map-marker-alt mt-1 flex-shrink-0"></i>
                        <span>Block E1, E3, E6, E7 & E10, Complex E, Federal Government Administrative Centre, 62590
                            Putrajaya, Malaysia</span>
                    </p>
                    <p class="text-gray-300 flex items-center space-x-2">
                        <i class="fas fa-phone"></i>
                        <a href="tel:03-88831888" class="hover:text-white transition-colors">03-8883 1888</a>
                    </p>
                    <p class="text-gray-300 flex items-center space-x-2">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:webmoh@moh.gov.my"
                            class="hover:text-white transition-colors">webmoh@moh.gov.my</a>
                    </p>
                    <p class="text-gray-300 flex items-center space-x-2">
                        <i class="fas fa-globe"></i>
                        <a href="https://www.moh.gov.my" target="_blank"
                            class="hover:text-white transition-colors">www.moh.gov.my</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div
            class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} MyCareX. All rights reserved.
            </div>

            <div class="flex flex-wrap gap-4 text-sm">
                <a href="#" class="text-gray-400 hover:text-white transition-colors">PDPA Compliance</a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors">Security</a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors">Sitemap</a>
            </div>
        </div>
    </div>
</footer>