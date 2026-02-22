<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $jobVacancy->title }} - Apply
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-900 via-blue-900 to-black min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('Job-Vacancies.show', $jobVacancy->id) }}"
                    class="inline-flex items-center gap-2 text-white/70 hover:text-white transition-colors duration-300 group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Back to Job Details</span>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content - Application Form -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 p-8 shadow-2xl"
                        x-data="{ fileName: '', fileSize: '', dragOver: false, handleFile(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.fileName = file.name;
                                this.fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                            }
                        } }">

                        <!-- Alerts -->
                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h2 class="text-3xl font-bold text-white mb-4">Apply for this Position</h2>

                        <form action="{{ route('Job-Application.store', $jobVacancy->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <!-- Resume Upload -->
                            <div class="space-y-2">
                                <label for="resume_file" class="block text-white font-medium flex items-center gap-2">
                                    Upload Resume (PDF)
                                </label>

                                <div 
                                    class="relative border-2 border-dashed rounded-xl transition-all duration-300"
                                    :class="dragOver ? 'border-pink-400 bg-pink-400/10' : 'border-white/20 bg-white/5'"
                                    @dragover.prevent="dragOver = true"
                                    @dragleave.prevent="dragOver = false"
                                    @drop.prevent="dragOver = false; $refs.fileInput.files = $event.dataTransfer.files; handleFile($event)"
                                >
                                    <input 
                                        type="file" 
                                        name="resume_file" 
                                        id="resume_file" 
                                        accept=".pdf" 
                                        required
                                        x-ref="fileInput"
                                        @change="handleFile($event)"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    >

                                    <div class="p-8 text-center">
                                        <div x-show="!fileName">
                                            <p class="text-white font-medium mb-1">Drop your resume here or click to browse</p>
                                            <p class="text-white/60 text-sm">PDF format only, max 10MB</p>
                                        </div>
                                        <div x-show="fileName" class="space-y-2">
                                            <p class="text-green-400 font-medium" x-text="fileName"></p>
                                            <p class="text-white/60 text-sm" x-text="fileSize"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit"
                                    class="w-full px-8 py-4 bg-gradient-to-r from-green-500 to-blue-600 text-white rounded-xl font-semibold text-lg hover:scale-[1.02] transition-all duration-300">
                                    Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar - Job Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 p-6 shadow-2xl sticky top-6">
                        <h3 class="text-xl font-bold text-white mb-4">Job Summary</h3>
                        <p class="text-white/80 mb-2"><strong>Company:</strong> {{ $jobVacancy->company->name }}</p>
                        <p class="text-white/80 mb-2"><strong>Location:</strong> {{ $jobVacancy->location }}</p>
                        <p class="text-white/80 mb-2"><strong>Type:</strong> {{ $jobVacancy->type }}</p>
                        <p class="text-white/80"><strong>Salary:</strong> {{ $jobVacancy->salary ? '$'.number_format($jobVacancy->salary) : 'Competitive' }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
