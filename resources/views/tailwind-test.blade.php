<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind CSS Test - OJS Project</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="text-center mb-12">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-800 mb-4">
                🎉 Tailwind CSS Test Page
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                This page demonstrates that Tailwind CSS is properly installed and working in your Laravel OJS project.
            </p>
        </header>

        <!-- Test Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <!-- Card 1: Colors & Gradients -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full mb-4 flex items-center justify-center">
                    <span class="text-white text-2xl">🎨</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Colors & Gradients</h3>
                <p class="text-gray-600">Beautiful gradient backgrounds and color utilities are working perfectly.</p>
                <div class="mt-4 flex space-x-2">
                    <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                    <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                    <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                    <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                </div>
            </div>

            <!-- Card 2: Typography -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-full mb-4 flex items-center justify-center">
                    <span class="text-white text-2xl">📝</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Typography</h3>
                <p class="text-gray-600 text-sm">Small text</p>
                <p class="text-gray-600 text-base">Base text</p>
                <p class="text-gray-800 text-lg font-medium">Large medium text</p>
                <p class="text-gray-900 text-xl font-bold">Extra large bold</p>
            </div>

            <!-- Card 3: Layout & Spacing -->
            <div class="bg-white rounded-xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                <div class="w-16 h-16 bg-gradient-to-r from-orange-500 to-red-500 rounded-full mb-4 flex items-center justify-center">
                    <span class="text-white text-2xl">📐</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Layout & Spacing</h3>
                <p class="text-gray-600 mb-4">Flexbox, grid, and spacing utilities are functioning correctly.</p>
                <div class="flex justify-between items-center">
                    <div class="w-8 h-8 bg-blue-300 rounded"></div>
                    <div class="w-8 h-8 bg-blue-400 rounded"></div>
                    <div class="w-8 h-8 bg-blue-500 rounded"></div>
                </div>
            </div>
        </div>

        <!-- Interactive Components -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Interactive Components</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Buttons -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Buttons</h3>
                    <div class="space-y-3">
                        <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                            Primary Button
                        </button>
                        <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                            Secondary Button
                        </button>
                        <button class="w-full border-2 border-green-500 text-green-500 hover:bg-green-500 hover:text-white font-medium py-2 px-4 rounded-lg transition-all duration-200">
                            Outline Button
                        </button>
                    </div>
                </div>

                <!-- Form Elements -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Form Elements</h3>
                    <div class="space-y-3">
                        <input type="text" placeholder="Text Input" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option>Select Option</option>
                            <option>Option 1</option>
                            <option>Option 2</option>
                        </select>
                        <textarea placeholder="Textarea" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Responsive Test -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg p-8 text-white">
            <h2 class="text-2xl font-bold mb-4 text-center">Responsive Design Test</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <p class="font-semibold">Mobile</p>
                    <p class="text-sm opacity-90">1 column</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <p class="font-semibold">Tablet</p>
                    <p class="text-sm opacity-90">2 columns</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <p class="font-semibold">Desktop</p>
                    <p class="text-sm opacity-90">4 columns</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-lg p-4">
                    <p class="font-semibold">Large</p>
                    <p class="text-sm opacity-90">4 columns</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <div class="mt-12 text-center">
            <div class="inline-flex items-center px-6 py-3 bg-green-100 border border-green-200 rounded-full">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-green-800 font-medium">✅ Tailwind CSS is working perfectly!</span>
            </div>
        </div>
    </div>
</body>
</html>
