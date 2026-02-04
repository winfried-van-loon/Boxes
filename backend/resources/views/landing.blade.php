<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boxes - Organize Your Move & Storage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <span class="text-2xl font-bold gradient-bg bg-clip-text text-transparent">📦 Boxes</span>
                </div>
                <div class="flex space-x-4">
                    <a href="#features" class="text-gray-700 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium">Features</a>
                    <a href="#how-it-works" class="text-gray-700 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium">How It Works</a>
                    <a href="#download" class="gradient-bg text-white px-4 py-2 rounded-md text-sm font-medium hover:opacity-90">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    Moving Made Simple.<br>Storage Made Smart.
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-purple-100">
                    Track your boxes, find your belongings, and collaborate with friends during your move or storage.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#download" class="bg-white text-purple-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-gray-100 transition">
                        Start Free Today
                    </a>
                    <a href="#how-it-works" class="border-2 border-white text-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-purple-600 transition">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Everything You Need to Stay Organized</h2>
                <p class="text-xl text-gray-600">Powerful features to make your move stress-free</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">📦</div>
                    <h3 class="text-xl font-semibold mb-2">Smart Box Tracking</h3>
                    <p class="text-gray-600">Label and track all your boxes with names, numbers, and custom tags. Never lose track of your belongings again.</p>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">📸</div>
                    <h3 class="text-xl font-semibold mb-2">Photo Documentation</h3>
                    <p class="text-gray-600">Take photos of your boxes and their contents. AI-powered recognition helps identify what's inside.</p>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">🏠</div>
                    <h3 class="text-xl font-semibold mb-2">Room Organization</h3>
                    <p class="text-gray-600">Assign boxes to current and target rooms. Filter and search by location to find exactly what you need.</p>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">📱</div>
                    <h3 class="text-xl font-semibold mb-2">Multi-Platform Access</h3>
                    <p class="text-gray-600">Use Boxes on web, iOS, and Android. Your data syncs seamlessly across all devices.</p>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="text-xl font-semibold mb-2">Collaborate with Friends</h3>
                    <p class="text-gray-600">Connect with friends using QR codes. Share box information and coordinate your move together.</p>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">🔒</div>
                    <h3 class="text-xl font-semibold mb-2">Secure & Private</h3>
                    <p class="text-gray-600">Modern passkey authentication. No passwords to remember, just secure biometric login.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-xl text-gray-600">Get organized in three simple steps</p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="gradient-bg text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                    <h3 class="text-xl font-semibold mb-3">Sign Up & Create Boxes</h3>
                    <p class="text-gray-600">Register with just your email. Start creating boxes and add photos, descriptions, and items.</p>
                </div>

                <div class="text-center">
                    <div class="gradient-bg text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                    <h3 class="text-xl font-semibold mb-3">Organize & Tag</h3>
                    <p class="text-gray-600">Assign boxes to rooms, add custom fields, and nest boxes within boxes for complete organization.</p>
                </div>

                <div class="text-center">
                    <div class="gradient-bg text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                    <h3 class="text-xl font-semibold mb-3">Find & Move</h3>
                    <p class="text-gray-600">Use powerful filters and search to find your items instantly. Track your move from start to finish.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="download" class="gradient-bg text-white py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Get Started?</h2>
            <p class="text-xl mb-8">Join thousands of people who have simplified their moves with Boxes.</p>
            
            <div class="bg-white/10 backdrop-blur-lg rounded-lg p-8 mb-8">
                <h3 class="text-2xl font-semibold mb-4">Download Now</h3>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#" class="bg-black text-white px-6 py-3 rounded-lg flex items-center justify-center space-x-2 hover:bg-gray-800 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                        </svg>
                        <span>App Store</span>
                    </a>
                    <a href="#" class="bg-black text-white px-6 py-3 rounded-lg flex items-center justify-center space-x-2 hover:bg-gray-800 transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
                        </svg>
                        <span>Google Play</span>
                    </a>
                </div>
                <div class="mt-6">
                    <a href="#" class="text-white underline hover:no-underline">Or use the web app →</a>
                </div>
            </div>

            <p class="text-purple-100">Free to use. No credit card required.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-lg font-semibold mb-4">Boxes</h4>
                    <p class="text-gray-400">Making moves and storage simple for everyone.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#features" class="hover:text-white">Features</a></li>
                        <li><a href="#" class="hover:text-white">Pricing</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">About</a></li>
                        <li><a href="#" class="hover:text-white">Blog</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white">Privacy</a></li>
                        <li><a href="#" class="hover:text-white">Terms</a></li>
                        <li><a href="#" class="hover:text-white">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
                <p>&copy; 2026 Boxes. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
