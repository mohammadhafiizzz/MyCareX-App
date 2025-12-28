<!-- Terminate Access Modal -->
<div id="terminateModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="absolute inset-0 bg-gray-500/30 transition-opacity" aria-hidden="true"></div>

    <div class="relative flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex flex-col items-center text-center">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-2" id="modal-title">
                        Terminate Access
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Are you sure you want to terminate your access to <span id="terminatePatientName" class="font-bold text-gray-900"></span>'s medical records? You will no longer be able to view their data.
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            Please type <span class="font-bold text-gray-900 uppercase">TERMINATE</span> to confirm:
                        </p>
                        <div class="mt-4">
                            <input type="text" id="confirm_terminate_word" class="block w-full px-4 py-3 rounded-lg border border-gray-200 transition-all text-sm" placeholder="Type 'TERMINATE' here">
                            <p id="terminate_error" class="mt-1 text-xs text-red-600 hidden">Please type 'TERMINATE' in uppercase to confirm.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <button type="button" id="confirmTerminateBtn" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-br from-red-500/90 to-red-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40 hover:from-red-500 hover:to-red-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50 focus-visible:ring-offset-0">
                    Terminate
                </button>
                <button type="button" id="closeTerminateModal" class="inline-flex gap-2 items-center justify-center px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-gray-200/30 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
