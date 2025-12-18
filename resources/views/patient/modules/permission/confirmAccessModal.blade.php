<!-- Confirm Access Modal -->
<div id="confirmAccessModal" class="fixed inset-0 bg-gray-900/50 hidden items-center justify-center z-50 transition-all duration-100">
    <div class="bg-white rounded-lg shadow-2xl max-w-md w-full mx-4" id="modalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">
                <i class="fas fa-shield-alt text-blue-600 mr-2"></i>
                Grant Access Request
            </h3>
            <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" onclick="closeConfirmAccessModal()">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <div class="mb-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-shield text-blue-600 text-2xl"></i>
                </div>
                <p class="text-center text-gray-700 mb-2">
                    You are about to grant access to:
                </p>
                <p class="text-center text-lg font-semibold text-gray-900" id="doctorName">
                    <!-- Doctor name will be inserted here -->
                </p>
                <p class="text-center text-sm text-gray-600" id="providerName">
                    <!-- Provider name will be inserted here -->
                </p>
            </div>

            <!-- Access Details -->
            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                <h4 class="text-sm font-semibold text-gray-900 mb-2">Access Details:</h4>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Requested Access:</span>
                        <span class="font-medium text-gray-900" id="accessScope">
                            <!-- Access scope will be inserted here -->
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Access Duration:</span>
                        <span class="font-medium text-gray-900">1 Year</span>
                    </div>
                </div>
            </div>

            <!-- Expiry Date Input -->
            <div class="mb-4">
                <label for="expiryDate" class="block text-sm font-medium text-gray-700 mb-2">
                    Set Access Expiry Date
                </label>
                <input type="date" 
                       id="expiryDate" 
                       name="expiry_date"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       required>
                <p class="mt-1 text-xs text-gray-500">
                    Specify when this access should expire
                </p>
            </div>

            <!-- Warning Message -->
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-4">
                <p class="text-sm text-amber-800">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    This doctor will be able to view your medical records based on the granted scope.
                </p>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex gap-3 p-6 border-t border-gray-200 bg-gray-50 rounded-b-xl">
            <button type="button" 
                    onclick="closeConfirmAccessModal()" 
                    class="flex-1 px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button type="button" 
                    onclick="confirmAccessGrant()" 
                    id="confirmBtn"
                    class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors">
                <span id="confirmBtnText">Grant Access</span>
                <span id="confirmBtnLoader" class="hidden">
                    <i class="fas fa-spinner fa-spin mr-2"></i>Processing...
                </span>
            </button>
        </div>
    </div>
</div>
