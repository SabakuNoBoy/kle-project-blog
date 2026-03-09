@if(session('admin_access_denied'))
    <div x-data="{ show: true }" x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        {{-- Backdrop --}}
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

        {{-- Modal Box --}}
        <div x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full text-center border border-gray-100">

            <div class="w-20 h-20 mx-auto bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            <h3 class="text-3xl font-bold text-gray-900 mb-4">Unauthorized Access</h3>
            <p class="text-gray-500 mb-8 text-base">You do not have permission to access this panel. Please login with an
                administrator account
                or return to the frontend.</p>

            <div class="flex flex-col gap-3">
                <a href="http://localhost:8001"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 rounded-xl transition-colors text-lg">
                    Return to KLE Blog Home
                </a>

                <button @click="show = false"
                    class="w-full bg-white border-2 border-gray-200 hover:bg-gray-50 text-gray-700 font-medium py-3 rounded-xl transition-colors text-lg">
                    Login with a Different (Admin) Account
                </button>
            </div>
        </div>
    </div>
@endif