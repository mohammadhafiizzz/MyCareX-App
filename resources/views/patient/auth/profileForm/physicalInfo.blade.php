<!-- Edit Physical Information Modal -->
<div id="editPhysicalInfo" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40" aria-hidden="true" onclick="closeModal('editPhysicalInfo', 'editPhysicalInfoContent')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div id="editPhysicalInfoContent" class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Edit Physical Information</h3>
                <button type="button" onclick="closeModal('editPhysicalInfo', 'editPhysicalInfoContent')" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('patient.profile.update.physical') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Height -->
                        <div>
                            <label for="edit_height" class="block text-xs font-bold text-gray-400 uppercase mb-1">Height (cm)</label>
                            <input type="number" id="edit_height" name="height" step="0.01" min="1" max="999.99"
                                value="{{ Auth::guard('patient')->user()->height }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                placeholder="Enter height in cm">
                            <p class="text-[10px] text-gray-500 mt-1 italic">Optional - helps calculate BMI</p>
                        </div>

                        <!-- Weight -->
                        <div>
                            <label for="edit_weight" class="block text-xs font-bold text-gray-400 uppercase mb-1">Weight (kg)</label>
                            <input type="number" id="edit_weight" name="weight" step="0.01" min="1" max="999.99"
                                value="{{ Auth::guard('patient')->user()->weight }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                placeholder="Enter weight in kg">
                            <p class="text-[10px] text-gray-500 mt-1 italic">Optional - helps calculate BMI</p>
                        </div>

                        <!-- Current BMI Display -->
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Current BMI</label>
                            <div class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm">
                                @if(Auth::guard('patient')->user()->bmi)
                                    <span class="font-bold text-gray-900">{{ Auth::guard('patient')->user()->bmi }}</span>
                                    @php
                                        $bmi = Auth::guard('patient')->user()->bmi;
                                        $bmiColor = 'text-gray-500';
                                        $bmiLabel = '';
                                        if ($bmi < 18.5) { $bmiColor = 'text-blue-600'; $bmiLabel = '(Underweight)'; }
                                        elseif ($bmi < 25) { $bmiColor = 'text-green-600'; $bmiLabel = '(Normal)'; }
                                        elseif ($bmi < 30) { $bmiColor = 'text-yellow-600'; $bmiLabel = '(Overweight)'; }
                                        else { $bmiColor = 'text-red-600'; $bmiLabel = '(Obese)'; }
                                    @endphp
                                    <span class="{{ $bmiColor }} ml-2 font-medium">{{ $bmiLabel }}</span>
                                @else
                                    <span class="text-gray-500 italic">BMI will be calculated when height and weight are provided</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                            <div class="text-xs text-blue-800">
                                <p class="font-bold mb-1 uppercase">BMI Categories:</p>
                                <div class="grid grid-cols-2 gap-x-4 gap-y-1">
                                    <p>• Underweight: < 18.5</p>
                                    <p>• Normal: 18.5 - 24.9</p>
                                    <p>• Overweight: 25.0 - 29.9</p>
                                    <p>• Obese: 30.0+</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('editPhysicalInfo', 'editPhysicalInfoContent')" class="px-4 py-2 text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white rounded-lg shadow-sm hover:shadow transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-sm transition-all">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>