<!-- Edit Physical Information Modal -->
<div id="editPhysicalInfo"
    class="fixed inset-0 bg-gray-950/50 z-50 flex hidden items-start justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 my-4 min-h-fit max-h-screen overflow-y-auto"
        id="editPhysicalInfoContent">
        <!-- Modal Header -->
        <div
            class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white rounded-t-xl z-10">
            <h2 class="text-xl font-bold text-gray-900">Edit Physical Information</h2>
            <button class="text-gray-400 cursor-pointer hover:text-gray-600 transition-colors" id="closeeditPhysicalInfo">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body - Scrollable Content -->
        <div class="overflow-y-auto flex-1">
            <form action="{{ route('patient.profile.update.physical') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Height -->
                    <div>
                        <label for="edit_height" class="block text-sm font-medium text-gray-700 mb-2">Height
                            (cm)</label>
                        <input type="number" id="edit_height" name="height" step="0.01" min="1" max="999.99"
                            value="{{ Auth::guard('patient')->user()->height }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                            placeholder="Enter height in cm">
                        <p class="text-xs text-gray-500 mt-1">Optional - helps calculate BMI</p>
                    </div>

                    <!-- Weight -->
                    <div>
                        <label for="edit_weight" class="block text-sm font-medium text-gray-700 mb-2">Weight
                            (kg)</label>
                        <input type="number" id="edit_weight" name="weight" step="0.01" min="1" max="999.99"
                            value="{{ Auth::guard('patient')->user()->weight }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                            placeholder="Enter weight in kg">
                        <p class="text-xs text-gray-500 mt-1">Optional - helps calculate BMI</p>
                    </div>

                    <!-- Current BMI Display -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current BMI</label>
                        <div class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm sm:text-base">
                            @if(Auth::guard('patient')->user()->bmi)
                                <span class="font-medium">{{ Auth::guard('patient')->user()->bmi }}</span>
                                @if(Auth::guard('patient')->user()->bmi < 18.5)
                                    <span class="text-blue-600 ml-2">(Underweight)</span>
                                @elseif(Auth::guard('patient')->user()->bmi >= 18.5 && Auth::guard('patient')->user()->bmi < 25)
                                    <span class="text-green-600 ml-2">(Normal)</span>
                                @elseif(Auth::guard('patient')->user()->bmi >= 25 && Auth::guard('patient')->user()->bmi < 30)
                                    <span class="text-yellow-600 ml-2">(Overweight)</span>
                                @else
                                    <span class="text-red-600 ml-2">(Obese)</span>
                                @endif
                            @else
                                <span class="text-gray-500">BMI will be calculated when height and weight are
                                    provided</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 p-4 rounded-lg mt-6">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">BMI Categories:</p>
                            <ul class="space-y-1">
                                <li>• Underweight: Below 18.5</li>
                                <li>• Normal weight: 18.5 - 24.9</li>
                                <li>• Overweight: 25.0 - 29.9</li>
                                <li>• Obese: 30.0 and above</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer - Sticky at bottom -->
                <div
                    class="flex flex-col sm:flex-row items-center justify-start space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t border-gray-200 sticky bottom-0 bg-white">
                    <button type="submit"
                        class="w-full cursor-pointer sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm sm:text-base">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                    <button type="button"
                        class="w-full cursor-pointer sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium text-sm sm:text-base"
                        onclick="closeModal('editPhysicalInfo', 'editPhysicalInfoContent')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>