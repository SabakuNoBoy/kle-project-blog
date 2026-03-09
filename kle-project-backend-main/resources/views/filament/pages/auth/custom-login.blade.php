<x-filament-panels::page.simple>
    <x-filament-panels::page.simple>
        <style>
            /* Light mode explicit colors */
            .fi-custom-heading {
                color: #111827 !important;
                /* gray-900 */
            }

            .fi-custom-text {
                color: #6b7280 !important;
                /* gray-500 */
            }

            .fi-custom-back {
                color: #6b7280 !important;
                /* gray-500 */
            }

            .fi-custom-back:hover {
                color: #dc2626 !important;
                /* red-600 */
            }

            /* Dark mode explicit colors */
            .dark .fi-custom-heading {
                color: #ffffff !important;
            }

            .dark .fi-custom-text {
                color: #9ca3af !important;
                /* gray-400 */
            }

            .dark .fi-custom-btn-text {
                color: #ef4444 !important;
                border-color: #ef4444 !important;
            }

            .dark .fi-custom-btn-hover:hover {
                background-color: rgba(127, 29, 29, 0.2) !important;
            }

            .dark .fi-custom-back {
                color: #9ca3af !important;
                /* gray-400 */
            }

            .dark .fi-custom-back:hover {
                color: #ef4444 !important;
                /* red-500 */
            }
        </style>
        <div x-data="{ showLogin: false }" class="w-full">
            <!-- Initial Options View -->
            <div x-show="!showLogin" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100" class="flex flex-col space-y-4">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold tracking-tight fi-custom-heading">
                        Hoş Geldiniz
                    </h2>
                    <p class="mt-2 text-sm fi-custom-text">
                        Lütfen devam etmek için bir seçenek belirleyin.
                    </p>
                </div>

                <a href="{{ env('FRONTEND_URL', 'http://localhost:8001') }}"
                    class="w-full justify-center text-center items-center gap-2 rounded-full border border-transparent bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:focus:ring-2 hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition">
                    Siteye Dön
                </a>

                <button @click="showLogin = true" type="button"
                    class="w-full justify-center text-center items-center gap-2 rounded-full border-2 border-red-600 bg-transparent px-4 py-3 text-sm font-semibold text-red-600 shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 transition fi-custom-btn-text fi-custom-btn-hover">
                    Admin Girişi
                </button>
            </div>

            <!-- Real Login Form View -->
            <div x-show="showLogin" style="display: none;" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100">
                <button @click="showLogin = false" type="button"
                    class="mb-6 flex items-center text-sm font-medium transition fi-custom-back">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Geri Dön
                </button>

                <x-filament-panels::form id="form" wire:submit="authenticate">
                    {{ $this->form }}

                    <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
                        :full-width="$this->hasFullWidthFormActions()" />
                </x-filament-panels::form>
            </div>
        </div>
    </x-filament-panels::page.simple>