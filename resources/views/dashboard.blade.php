<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>School Management System</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Tailwind CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    </head>
    <body class="antialiased bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen">
            <!-- Sidebar -->
            <aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0">
                <div class="h-full px-3 py-4 overflow-y-auto bg-white dark:bg-gray-800">
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">School Management</h1>
                    </div>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i class="fas fa-home w-5 h-5"></i>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i class="fas fa-users w-5 h-5"></i>
                                <span class="ml-3">Students</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i class="fas fa-chalkboard-teacher w-5 h-5"></i>
                                <span class="ml-3">Teachers</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i class="fas fa-user-friends w-5 h-5"></i>
                                <span class="ml-3">Parents</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i class="fas fa-book w-5 h-5"></i>
                                <span class="ml-3">Classes</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i class="fas fa-user-graduate w-5 h-5"></i>
                                <span class="ml-3">Grades</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i class="fas fa-calendar-alt w-5 h-5"></i>
                                <span class="ml-3">Schedule</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                                <i class="fas fa-chart-line w-5 h-5"></i>
                                <span class="ml-3">Attendance</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="p-4 sm:ml-64">
                <!-- Top Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                                <i class="fas fa-users text-blue-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Students</p>
                                <h3 class="text-xl font-bold text-gray-700 dark:text-white">1,234</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                                <i class="fas fa-chalkboard-teacher text-green-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Teachers</p>
                                <h3 class="text-xl font-bold text-gray-700 dark:text-white">85</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                                <i class="fas fa-book text-yellow-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Classes</p>
                                <h3 class="text-xl font-bold text-gray-700 dark:text-white">32</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                                <i class="fas fa-calendar-check text-red-500"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Attendance Rate</p>
                                <h3 class="text-xl font-bold text-gray-700 dark:text-white">95%</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities and Quick Actions -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Recent Activities -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Recent Activities</h2>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                                    <i class="fas fa-user-plus text-blue-500"></i>
                                </span>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">New student registered</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">John Doe - Grade 10</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">2 hours ago</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                                    <i class="fas fa-file-alt text-green-500"></i>
                                </span>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Grade report generated</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Class 10A - Mathematics</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">5 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Quick Actions</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <button class="p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                                <i class="fas fa-user-plus text-blue-500 mb-2"></i>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Add Student</p>
                            </button>
                            <button class="p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                                <i class="fas fa-chalkboard-teacher text-green-500 mb-2"></i>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Add Teacher</p>
                            </button>
                            <button class="p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-800 transition-colors">
                                <i class="fas fa-book text-yellow-500 mb-2"></i>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Create Class</p>
                            </button>
                            <button class="p-4 bg-red-50 dark:bg-red-900 rounded-lg hover:bg-red-100 dark:hover:bg-red-800 transition-colors">
                                <i class="fas fa-calendar-plus text-red-500 mb-2"></i>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Schedule Event</p>
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Mobile menu button -->
        <button type="button" class="sm:hidden fixed bottom-4 right-4 inline-flex items-center justify-center p-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-bars"></i>
        </button>

        <script>
            // Mobile menu toggle
            const menuButton = document.querySelector('button[type="button"]');
            const sidebar = document.querySelector('aside');
            
            menuButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        </script>
    </body>
</html>
