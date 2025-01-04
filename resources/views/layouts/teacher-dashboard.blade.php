<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <!-- Add Tailwind CSS or your preferred CSS framework -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="flex">
        <div class="bg-gray-800 text-white w-64 min-h-screen">
            <div class="p-4">
                <h1 class="text-2xl font-semibold">Teacher Dashboard</h1>
            </div>
            <nav class="mt-6">
                <a href="{{ route('dashboard.teacher') }}" class="block py-2 px-4 hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('teacher.profile') }}" class="block py-2 px-4 hover:bg-gray-700">Profile</a>
                <a href="{{ route('teacher.classes') }}" class="block py-2 px-4 hover:bg-gray-700">Classes</a>
                <a href="{{ route('teacher.schedule') }}" class="block py-2 px-4 hover:bg-gray-700">Schedule</a>
                
            </nav>
        </div>
        <div class="absolute bottom-0 left-0 right-0 p-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center p-2 w-full text-gray-900 rounded-lg hover:bg-red-50 group transition-colors duration-200">
                    <i class="fas fa-sign-out-alt w-5 h-5 text-red-500 transition duration-75"></i>
                    <span class="ml-3">Logout</span>
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            @yield('content')
        </div>
    </div>
</body>
</html>