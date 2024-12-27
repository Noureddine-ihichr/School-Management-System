<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Scholify</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%234f46e5' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-gray-50 bg-pattern min-h-screen">
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0">
        <div class="h-full px-3 py-4 overflow-y-auto bg-white/80 backdrop-blur-sm border-r border-gray-200">
            <div class="flex items-center mb-5 p-2">
                <i class="fas fa-school text-2xl text-indigo-600 mr-2"></i>
                <span class="text-xl font-semibold text-gray-800">Scholify</span>
            </div>
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-indigo-50 group transition-colors duration-200">
                        <i class="fas fa-home w-5 h-5 text-indigo-500 transition duration-75"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-indigo-50 group transition-colors duration-200">
                        <i class="fas fa-book w-5 h-5 text-indigo-500 transition duration-75"></i>
                        <span class="ml-3">My Courses</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-indigo-50 group transition-colors duration-200">
                        <i class="fas fa-calendar-alt w-5 h-5 text-indigo-500 transition duration-75"></i>
                        <span class="ml-3">Schedule</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-indigo-50 group transition-colors duration-200">
                        <i class="fas fa-tasks w-5 h-5 text-indigo-500 transition duration-75"></i>
                        <span class="ml-3">Assignments</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-indigo-50 group transition-colors duration-200">
                        <i class="fas fa-chart-bar w-5 h-5 text-indigo-500 transition duration-75"></i>
                        <span class="ml-3">Grades</span>
                    </a>
                </li>
            </ul>
            <div class="absolute bottom-0 left-0 right-0 p-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center p-2 w-full text-gray-900 rounded-lg hover:bg-red-50 group transition-colors duration-200">
                        <i class="fas fa-sign-out-alt w-5 h-5 text-red-500 transition duration-75"></i>
                        <span class="ml-3">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        <!-- Top Navigation -->
        <nav class="bg-white/80 backdrop-blur-sm border border-gray-200 px-4 py-2.5 rounded-lg mb-4 flex justify-between items-center">
            <div class="flex items-center">
                <button class="sm:hidden mr-3" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-gray-500 text-lg"></i>
                </button>
                <h1 class="text-xl font-semibold text-gray-800">Student Dashboard</h1>
            </div>
            <div class="flex items-center gap-4">
                <button class="text-gray-500 hover:text-indigo-600 transition-colors duration-200">
                    <i class="fas fa-bell text-xl"></i>
                </button>
                <div class="flex items-center">
                    <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name=Student&background=6366f1&color=fff" alt="Student">
                    <span class="ml-2 text-sm font-medium text-gray-900">Student Name</span>
                </div>
            </div>
        </nav>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <i class="fas fa-book text-indigo-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Enrolled Courses</h3>
                        <p class="text-xl font-semibold text-gray-900">6</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-tasks text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Pending Tasks</h3>
                        <p class="text-xl font-semibold text-gray-900">4</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Average Grade</h3>
                        <p class="text-xl font-semibold text-gray-900">85%</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-calendar-check text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-500">Attendance</h3>
                        <p class="text-xl font-semibold text-gray-900">92%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Tasks & Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Upcoming Tasks</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-file-alt text-indigo-500 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-800">Math Assignment</p>
                                <p class="text-sm text-gray-500">Due Tomorrow</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-full">Pending</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-book text-indigo-500 mr-3"></i>
                            <div>
                                <p class="font-medium text-gray-800">Physics Quiz</p>
                                <p class="text-sm text-gray-500">Next Week</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">Upcoming</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white/80 backdrop-blur-sm border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity</h3>
                <div class="space-y-3">
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-800">Completed Biology Assignment</p>
                            <p class="text-sm text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                        <i class="fas fa-book text-blue-500 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-800">Attended Chemistry Class</p>
                            <p class="text-sm text-gray-500">Yesterday</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('-translate-x-full');
        }
    </script>
</body>
</html>