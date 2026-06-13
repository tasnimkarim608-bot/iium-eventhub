<x-guest-layout>
    <div class="relative">
        <!-- Background Image with opacity -->
        <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=1600');"></div>
        
        <div class="relative bg-white rounded-lg shadow-xl p-8 max-w-md mx-auto">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">IIUM Event Hub</h2>
                <p class="text-gray-600 mt-2">Select your role to continue</p>
            </div>

            <!-- Role Selection Buttons -->
            <div class="flex gap-4 mb-8">
                <button id="studentRoleBtn" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
                    🎓 Student
                </button>
                <button id="organizerRoleBtn" class="w-1/2 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition">
                    📋 Organizer
                </button>
            </div>

            <!-- Student Login Form -->
            <div id="studentLoginForm" class="login-form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role" value="student">
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Matric ID</label>
                        <input type="text" name="email" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g., 2417966" required>
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-2">Password</label>
                        <input type="password" name="password" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300">
                            <span class="ms-2 text-gray-600">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg mt-6 transition">
                        Login as Student
                    </button>
                </form>
            </div>

            <!-- Organizer Login Form -->
            <div id="organizerLoginForm" class="login-form hidden">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role" value="organiser">
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Email Address</label>
                        <input type="email" name="email" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="organizer@iium.edu.my" required>
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-2">Password</label>
                        <input type="password" name="password" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300">
                            <span class="ms-2 text-gray-600">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:underline">Forgot password?</a>
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-lg mt-6 transition">
                        Login as Organizer
                    </button>
                </form>
            </div>

            <div class="text-center mt-6">
                <p class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register here</a></p>
            </div>
        </div>
    </div>

    <script>
        const studentBtn = document.getElementById('studentRoleBtn');
        const organizerBtn = document.getElementById('organizerRoleBtn');
        const studentForm = document.getElementById('studentLoginForm');
        const organizerForm = document.getElementById('organizerLoginForm');

        studentBtn.addEventListener('click', function() {
            studentForm.classList.remove('hidden');
            organizerForm.classList.add('hidden');
            studentBtn.classList.add('bg-blue-700');
            organizerBtn.classList.remove('bg-green-700');
            organizerBtn.classList.add('bg-green-600');
        });

        organizerBtn.addEventListener('click', function() {
            organizerForm.classList.remove('hidden');
            studentForm.classList.add('hidden');
            organizerBtn.classList.add('bg-green-700');
            studentBtn.classList.remove('bg-blue-700');
            studentBtn.classList.add('bg-blue-600');
        });
    </script>
</x-guest-layout>