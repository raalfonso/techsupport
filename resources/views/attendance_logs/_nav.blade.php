@php
    $isAdmin    = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
    $canViewNav = $isAdmin || auth()->user()->authAssignments()->whereIn('item_name', ['HR_admin', 'depthead'])->exists();
@endphp

<nav class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 p-4 shadow-md top-0 z-50 min-w-full fixed max-h-16">
    <div class="flex items-center justify-between container mx-auto w-full">
        <div class="text-lg font-bold text-gray-800 dark:text-white flex items-center">
            <img src="{{ asset('img/itd_logo.png') }}" alt="ITD Logo" class="h-24 w-auto p-0 rounded">
            BCDA ClockWize
        </div>

        <div class="hidden md:flex items-center space-x-1">
            @if($canViewNav)
            <a href="{{ route('attendance.dashboard') }}" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
                <i class="material-icons text-lg">dashboard</i><span>Dashboard</span>
            </a>
            <a href="{{ route('attendance.present-today') }}" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
                <i class="material-icons text-lg">people</i><span>On Duty</span>
            </a>
            <a href="{{ route('attendance.reports') }}" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
                <i class="material-icons text-lg">assessment</i><span>Reports</span>
            </a>
            @endif
            <p class="text-gray-600 dark:text-gray-400 px-3 py-2 text-sm font-medium">{{ auth()->user()->name }}</p>

            {{-- Dark mode toggle --}}
            <button id="theme-toggle" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition" title="Toggle dark mode">
                <i class="material-icons text-xl" id="theme-icon">light_mode</i>
            </button>
        </div>

        <div class="md:hidden flex items-center gap-2">
            <button id="theme-toggle-mobile" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                <i class="material-icons text-xl" id="theme-icon-mobile">light_mode</i>
            </button>
            <button id="mobile-menu-button" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 focus:outline-none">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-slate-800 pt-2 pb-3 space-y-1 px-4 border-t border-gray-100 dark:border-slate-700">
        <p class="text-gray-600 dark:text-gray-400 px-3 py-2 text-sm font-medium">{{ auth()->user()->name }}</p>
        @if($canViewNav)
        <a href="{{ route('attendance.dashboard') }}" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
            <i class="material-icons text-lg">dashboard</i><span>Dashboard</span>
        </a>
        <a href="{{ route('attendance.present-today') }}" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
            <i class="material-icons text-lg">people</i><span>On Duty</span>
        </a>
        <a href="{{ route('attendance.reports') }}" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
            <i class="material-icons text-lg">assessment</i><span>Reports</span>
        </a>
        @endif
    </div>
</nav>

<script>
    // Dark mode init
    (function() {
        if (localStorage.getItem('cw-theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    })();

    function updateThemeIcon() {
        const isDark = document.documentElement.classList.contains('dark');
        const icon = document.getElementById('theme-icon');
        const iconMobile = document.getElementById('theme-icon-mobile');
        if (icon) icon.textContent = isDark ? 'dark_mode' : 'light_mode';
        if (iconMobile) iconMobile.textContent = isDark ? 'dark_mode' : 'light_mode';
    }

    function toggleTheme() {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('cw-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        updateThemeIcon();
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateThemeIcon();
        document.getElementById('theme-toggle')?.addEventListener('click', toggleTheme);
        document.getElementById('theme-toggle-mobile')?.addEventListener('click', toggleTheme);
        document.getElementById('mobile-menu-button')?.addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    });
</script>
