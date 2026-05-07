<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Modern Website') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!-- Tailwind CDN fallback if not built yet (useful for quick dev) -->
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['"Instrument Sans"', 'sans-serif'],
                            },
                        }
                    }
                }
            </script>
        @endif
    </head>
    <body class="font-sans antialiased text-gray-800 bg-gray-50">

        <!-- Navigation -->
        <nav class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="#" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                            ModernApp
                        </a>
                    </div>
                    <div class="hidden md:flex space-x-8 items-center">
                        <a href="#features" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Features</a>
                        <a href="#about" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">About</a>
                        <a href="#testimonials" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Testimonials</a>
                        <a href="#contact" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Contact</a>

                        @if (Route::has('login'))
                            <div class="border-l border-gray-200 pl-8 space-x-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium transition-colors">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-full font-medium hover:bg-blue-700 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Get Started</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button class="text-gray-600 hover:text-gray-900 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50/50"></div>
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100/50 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-100/50 blur-3xl"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight text-gray-900 mb-8 fade-in-up">
                    Build faster with <br class="hidden sm:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Modern Design</span>
                </h1>
                <p class="mt-4 text-xl md:text-2xl text-gray-600 max-w-3xl mx-auto mb-10 fade-in-up delay-100">
                    A beautiful, responsive, and dynamic template designed to convert visitors into customers. Experience the next level of UI design.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4 fade-in-up delay-200">
                    <a href="#features" class="bg-blue-600 text-white px-8 py-4 rounded-full font-semibold text-lg hover:bg-blue-700 transition-all shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-1">
                        Explore Features
                    </a>
                    <a href="#contact" class="bg-white text-gray-800 border border-gray-200 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm hover:shadow">
                        Contact Us
                    </a>
                </div>

                <div class="mt-20 fade-in-up delay-300">
                    <div class="relative rounded-2xl p-2 bg-white/50 backdrop-blur-sm border border-gray-200/50 shadow-2xl mx-auto max-w-5xl">
                        <div class="aspect-video bg-gray-100 rounded-xl overflow-hidden relative">
                            <!-- Placeholder for an actual dashboard screenshot or app image -->
                            <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                <svg class="w-20 h-20 opacity-20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-5-7l-3 3.72L9 13l-3 4h12l-4-5z"/></svg>
                            </div>
                            <!-- Simulated UI blocks -->
                            <div class="absolute top-4 left-4 right-4 h-12 bg-white rounded-lg shadow-sm border border-gray-100"></div>
                            <div class="absolute top-20 left-4 w-64 bottom-4 bg-white rounded-lg shadow-sm border border-gray-100"></div>
                            <div class="absolute top-20 left-72 right-4 bottom-4 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                                <div class="w-1/3 h-8 bg-gray-100 rounded mb-6"></div>
                                <div class="space-y-3">
                                    <div class="h-4 bg-gray-50 rounded w-full"></div>
                                    <div class="h-4 bg-gray-50 rounded w-5/6"></div>
                                    <div class="h-4 bg-gray-50 rounded w-4/6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-blue-600 font-semibold tracking-wide uppercase text-sm mb-3">Features</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Everything you need to succeed</h3>
                    <p class="text-lg text-gray-600">Our platform provides a comprehensive suite of tools designed to help you build, scale, and manage your business effectively.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Lightning Fast</h4>
                        <p class="text-gray-600 leading-relaxed">Optimized performance ensures your application loads instantly and provides a smooth user experience.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Highly Secure</h4>
                        <p class="text-gray-600 leading-relaxed">Built-in security measures protect your data and ensure your application is safe from vulnerabilities.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">Responsive Design</h4>
                        <p class="text-gray-600 leading-relaxed">Looks perfect on any device. Carefully crafted layouts that adapt beautifully to screens of all sizes.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="lg:w-1/2 relative">
                        <div class="aspect-square bg-gradient-to-tr from-blue-200 to-indigo-100 rounded-3xl overflow-hidden shadow-2xl relative">
                            <!-- Abstract shapes representing an image -->
                            <div class="absolute top-1/4 left-1/4 w-1/2 h-1/2 bg-white/40 rounded-full mix-blend-overlay filter blur-xl"></div>
                            <div class="absolute bottom-1/4 right-1/4 w-1/3 h-1/3 bg-blue-500/40 rounded-full mix-blend-overlay filter blur-xl"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-white text-9xl font-bold opacity-20">Design</span>
                            </div>
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-yellow-400 rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>
                        <div class="absolute -top-6 -left-6 w-32 h-32 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-70"></div>
                    </div>

                    <div class="lg:w-1/2">
                        <h2 class="text-blue-600 font-semibold tracking-wide uppercase text-sm mb-3">Why Choose Us</h2>
                        <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Built for the modern web</h3>
                        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                            We combine cutting-edge technology with elegant design to deliver digital experiences that not only look great but perform exceptionally well.
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">Modern Technologies</h4>
                                    <p class="mt-1 text-gray-600">Utilizing Laravel, Tailwind CSS, and the latest web standards.</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">User-Centric Design</h4>
                                    <p class="mt-1 text-gray-600">Focusing on accessibility, usability, and beautiful aesthetics.</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">Scalable Architecture</h4>
                                    <p class="mt-1 text-gray-600">Ready to grow with your business without compromising performance.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section id="testimonials" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-blue-600 font-semibold tracking-wide uppercase text-sm mb-3">Testimonials</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Loved by our users</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex text-yellow-400 mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <p class="text-gray-600 mb-6 italic">"This platform has completely transformed how we build and deploy our web applications. The design is flawless."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold">JD</div>
                            <div class="ml-3">
                                <h5 class="text-sm font-bold text-gray-900">John Doe</h5>
                                <p class="text-xs text-gray-500">Tech Lead</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex text-yellow-400 mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <p class="text-gray-600 mb-6 italic">"The user experience is incredibly smooth. My team was able to integrate the tools seamlessly in just a few days."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">AS</div>
                            <div class="ml-3">
                                <h5 class="text-sm font-bold text-gray-900">Alice Smith</h5>
                                <p class="text-xs text-gray-500">Product Manager</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex text-yellow-400 mb-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <p class="text-gray-600 mb-6 italic">"Highly recommend for anyone looking to step up their game. The responsive design alone is worth it."</p>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 font-bold">MJ</div>
                            <div class="ml-3">
                                <h5 class="text-sm font-bold text-gray-900">Mark Johnson</h5>
                                <p class="text-xs text-gray-500">Startup Founder</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="flex flex-col lg:flex-row">
                        <div class="lg:w-5/12 bg-blue-600 p-10 lg:p-12 text-white relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-700"></div>
                            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mt-20 -mr-20"></div>
                            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -mb-20 -ml-20"></div>

                            <div class="relative z-10">
                                <h3 class="text-3xl font-bold mb-4">Get in touch</h3>
                                <p class="mb-8 text-blue-100">We'd love to hear from you! Fill out the form and we will get back to you as soon as possible.</p>

                                <div class="space-y-6">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span class="ml-4 text-blue-50">hello@modernapp.com</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span class="ml-4 text-blue-50">+1 (555) 123-4567</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="ml-4 text-blue-50">123 Modern Street, Tech City</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:w-7/12 p-10 lg:p-12">
                            <form action="#" method="POST" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="first-name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                        <input type="text" id="first-name" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition-all bg-gray-50 focus:bg-white" placeholder="John">
                                    </div>
                                    <div>
                                        <label for="last-name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                        <input type="text" id="last-name" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition-all bg-gray-50 focus:bg-white" placeholder="Doe">
                                    </div>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" id="email" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition-all bg-gray-50 focus:bg-white" placeholder="john@example.com">
                                </div>
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                                    <textarea id="message" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition-all bg-gray-50 focus:bg-white resize-none" placeholder="How can we help you?"></textarea>
                                </div>
                                <div>
                                    <button type="button" class="w-full bg-blue-600 text-white font-medium py-3 rounded-xl hover:bg-blue-700 transition-colors shadow-md">
                                        Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300 py-12 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div class="col-span-1 md:col-span-1">
                        <span class="text-2xl font-bold text-white tracking-tight">ModernApp</span>
                        <p class="mt-4 text-gray-400 text-sm">Building beautiful, fast, and secure web applications for modern businesses.</p>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Product</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Company</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-white font-semibold mb-4">Legal</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-400">&copy; {{ date('Y') }} ModernApp. All rights reserved.</p>
                    <div class="flex space-x-4 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <span class="sr-only">GitHub</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>