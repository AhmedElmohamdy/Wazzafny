<x-main-layout title="Wazzafny - Find Your Job">
<div 
    x-data="{
        show: false,
        text: '',
        fullText: 'Dream Job',
        currentWord: 0,
        words: ['Dream Job', 'Career', 'Future', 'Opportunity'],
        mouseX: 0,
        mouseY: 0,
        typing() {
            let word = this.words[this.currentWord];
            let i = 0;
            this.text = '';
            let interval = setInterval(() => {
                this.text += word[i];
                i++;
                if (i >= word.length) {
                    clearInterval(interval);
                    setTimeout(() => {
                        this.erasing();
                    }, 2000);
                }
            }, 120);
        },
        erasing() {
            let interval = setInterval(() => {
                this.text = this.text.slice(0, -1);
                if (this.text.length === 0) {
                    clearInterval(interval);
                    this.currentWord = (this.currentWord + 1) % this.words.length;
                    setTimeout(() => this.typing(), 300);
                }
            }, 80);
        },
        handleMouseMove(e) {
            this.mouseX = e.clientX;
            this.mouseY = e.clientY;
        }
    }"
    x-init="
        setTimeout(() => { show = true; typing(); }, 400);
        window.addEventListener('mousemove', (e) => handleMouseMove(e));
    "
    @mousemove="handleMouseMove($event)"
    class="relative flex items-center justify-center h-screen overflow-hidden bg-gradient-to-br from-slate-900 via-blue-900 to-black"
>
    <!-- Animated Grid Background -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
    </div>

    <!-- Floating Circles Background with Mouse Parallax -->
    <div 
        class="absolute w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-pulse transition-transform duration-1000 ease-out"
        :style="`transform: translate(${mouseX * 0.02}px, ${mouseY * 0.02}px)`"
        style="top: 10%; left: 10%;"
    ></div>
    <div 
        class="absolute w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl animate-pulse transition-transform duration-1000 ease-out"
        :style="`transform: translate(${mouseX * -0.03}px, ${mouseY * -0.03}px)`"
        style="bottom: 10%; right: 10%;"
    ></div>
    <div 
        class="absolute w-64 h-64 bg-purple-500/15 rounded-full blur-3xl animate-pulse transition-transform duration-1000 ease-out"
        :style="`transform: translate(${mouseX * 0.015}px, ${mouseY * 0.025}px)`"
        style="top: 50%; left: 50%; transform: translate(-50%, -50%);"
    ></div>

    <!-- Floating Particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute w-2 h-2 bg-blue-400/40 rounded-full animate-float" style="top: 20%; left: 10%; animation-delay: 0s; animation-duration: 8s;"></div>
        <div class="absolute w-3 h-3 bg-indigo-400/30 rounded-full animate-float" style="top: 60%; left: 20%; animation-delay: 2s; animation-duration: 10s;"></div>
        <div class="absolute w-2 h-2 bg-purple-400/40 rounded-full animate-float" style="top: 40%; left: 80%; animation-delay: 4s; animation-duration: 12s;"></div>
        <div class="absolute w-4 h-4 bg-blue-300/20 rounded-full animate-float" style="top: 70%; left: 70%; animation-delay: 1s; animation-duration: 9s;"></div>
        <div class="absolute w-2 h-2 bg-indigo-300/35 rounded-full animate-float" style="top: 30%; left: 60%; animation-delay: 3s; animation-duration: 11s;"></div>
        <div class="absolute w-3 h-3 bg-blue-400/25 rounded-full animate-float" style="top: 80%; left: 40%; animation-delay: 5s; animation-duration: 13s;"></div>
    </div>

    <!-- Main Content -->
    <div 
        x-cloak 
        x-show="show" 
        x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0 translate-y-10"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="flex flex-col items-center text-center gap-6 z-10 px-4"
    >
        <!-- Badge -->
        <div 
            class="px-4 py-2 bg-blue-500/10 backdrop-blur-sm border border-blue-400/20 rounded-full text-sm text-blue-300 tracking-wide hover:bg-blue-500/20 hover:scale-105 transition-all duration-300 cursor-default"
            x-transition:enter="transition ease-out duration-700 delay-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            ✨ Welcome to Wazzafny
        </div>

        <!-- Main Heading -->
        <h1 
            class="text-4xl sm:text-6xl md:text-8xl font-bold tracking-tight text-white"
            x-transition:enter="transition ease-out duration-700 delay-500"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            Find Your 
            <span class="relative inline-block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400 font-serif italic">
                    <span x-text="text"></span>
                    <span class="animate-pulse">|</span>
                </span>
                <!-- Underline Animation -->
                <span class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></span>
            </span>
        </h1>

        <!-- Description -->
        <p 
            class="text-white/70 max-w-lg text-lg leading-relaxed"
            x-transition:enter="transition ease-out duration-700 delay-700"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            Discover thousands of opportunities and connect with companies 
            looking for your skills.
        </p>

        <!-- CTA Buttons -->
        <div 
            class="flex flex-col sm:flex-row gap-4 mt-4"
            x-transition:enter="transition ease-out duration-700 delay-900"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <!-- Create Account Button -->
            <a 
                href="{{ route('register') }}"
                class="group relative px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-full overflow-hidden transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/50"
            >
                <!-- Shimmer Effect -->
                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>
                
                <!-- Button Content -->
                <span class="relative z-10 flex items-center gap-2 font-semibold tracking-wide">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <span>Create Your Account</span>
                </span>
                
                <!-- Glow Effect -->
                <span class="absolute inset-0 rounded-full bg-blue-400/0 group-hover:bg-blue-400/20 blur-xl transition-all duration-300"></span>
            </a>

            <!-- Login Button -->
            <a 
                href="{{ route('login') }}"
                class="group relative px-8 py-4 bg-white/10 backdrop-blur-sm border-2 border-white/20 text-white rounded-full overflow-hidden transition-all duration-300 hover:scale-105 hover:bg-white/20 hover:border-white/30 hover:shadow-xl hover:shadow-white/20"
            >
                <!-- Button Content -->
                <span class="relative z-10 flex items-center gap-2 font-semibold tracking-wide">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    <span>Login</span>
                </span>
                
                <!-- Shine Effect on Hover -->
                <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>
            </a>
        </div>

        <!-- Stats Section -->
        <div 
            class="flex flex-wrap gap-8 mt-8 justify-center"
            x-transition:enter="transition ease-out duration-700 delay-1100"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
        >
            <div class="text-center group cursor-default">
                <div class="text-3xl font-bold text-white group-hover:scale-110 transition-transform duration-300">10K+</div>
                <div class="text-sm text-white/60">Active Jobs</div>
            </div>
            <div class="text-center group cursor-default">
                <div class="text-3xl font-bold text-white group-hover:scale-110 transition-transform duration-300">5K+</div>
                <div class="text-sm text-white/60">Companies</div>
            </div>
            <div class="text-center group cursor-default">
                <div class="text-3xl font-bold text-white group-hover:scale-110 transition-transform duration-300">50K+</div>
                <div class="text-sm text-white/60">Job Seekers</div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    
</div>

<style>
    @keyframes float {
        0%, 100% {
            transform: translateY(0) translateX(0);
            opacity: 0;
        }
        10% {
            opacity: 1;
        }
        90% {
            opacity: 1;
        }
        50% {
            transform: translateY(-100vh) translateX(50px);
        }
    }

    .animate-float {
        animation: float linear infinite;
    }

    [x-cloak] {
        display: none !important;
    }
</style>
</x-main-layout>