 <div class="absolute inset-x-0 top-0 z-50 max-w-2xl ">
    <!-- Success Message -->
    @if (session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             x-init="setTimeout(() => show = false, 3500)"
             class="mx-6 mt-6 px-4 py-3 bg-green-100 border-2 border-green-500 text-green-800 rounded-lg shadow-md"
             role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    </div>