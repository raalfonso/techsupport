<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Set the title from APP_NAME or provide a fallback --}}
    <title>{{ env('APP_NAME', 'IT Department') }}</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    
    {{-- Vite for compiling your Tailwind CSS and JS --}}
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
</head>
<body class="bg-slate-950 text-slate-100">
    <style>
        * {
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                sans-serif;
        }

        .management-shell {
            background:
                radial-gradient(circle at top left, rgba(56, 189, 248, 0.18), transparent 30%),
                radial-gradient(circle at top right, rgba(99, 102, 241, 0.22), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        }

        .glass-panel {
            backdrop-filter: blur(18px);
            background: rgba(255, 255, 255, 0.82);
        }
    </style>

    {{-- Include Tailwind CSS --}}
    {{-- Main Navbar --}}
    <nav class="bg-white p-4 shadow-md top-0 z-50 min-w-full fixed max-h-16">
        {{-- Outer container for full-width alignment --}}
        {{-- Inner container for content alignment --}}
        {{-- Outer container for full-width alignment --}}
        {{-- Inner container for content alignment --}}
       <div class="flex items-center justify-between container mx-auto w-full">
            {{-- Logo or Brand Name --}}
            <div class="text-lg font-bold text-gray-800 flex items-center">
                {{-- Logo image --}}
               <img src="{{ asset('img/itd_logo.png') }}" alt="ITD Logo" class="h-24 w-auto p-0 rounded">
                BCDA IT DIVISION {{-- Changed from MyBrand to match context --}}
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex space-x-4 float-right items-center">
                    {{-- Navigation links --}}
                    <a href="{{ route('survey.dashboard') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">dashboard</i>
                        {{-- Added icon for Dashboard --}}
                        Dashboard</a>

                    <a href="#about" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">assignment</i>
                        Survey Result
                    </a>

                    <a href="{{ route('qrcode', ['departmentCode' => auth()->user()->department_id]) }}"
                    class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium" target="_blank">
                        <i class="material-icons align-middle">qr_code</i>
                        QR Code
                    </a>

                    <a href="#contact" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">people</i>
                        Employee Registration
                    </a>

                    @if (auth()->user()->role === 'superadmin')
                        <a href="{{ route('survey.management') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="material-icons align-middle">settings</i>
                            User Management
                        </a>
                    @endif

                    {{-- User dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <!-- Username button -->
                        <button @click="open = !open"
                            class="flex items-center text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            {{ auth()->user()->name }}
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">

                            <!-- Change Password -->
                            <a href="{{ route('survey.account') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                <i class="material-icons mr-2 text-gray-500">lock</i> Account
                            </a>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('userSurvey.logout') }}">
                                @csrf
                                <button type="submit"
                                        class="flex w-full items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                    <i class="material-icons mr-2 text-gray-500">logout</i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            <button id="mobile-menu-button" class="rounded-full border border-slate-200 bg-white p-2 text-slate-700 shadow-sm md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white md:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-3 sm:px-6 lg:px-8">
                <a href="{{ route('survey.dashboard') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                <a href="{{ route('survey.management') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">User Management</a>
                <a href="{{ route('survey.account') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Account</a>
                <form method="POST" action="{{ route('userSurvey.logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-100">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="management-shell min-h-screen pt-24">
        <section class="mx-auto max-w-7xl px-4 pb-10 sm:px-6 lg:px-8">
            <div class="glass-panel relative overflow-hidden rounded-3xl border border-white/70 p-6 shadow-[0_20px_60px_rgba(15,23,42,0.08)] sm:p-8">
                <div class="absolute inset-y-0 right-0 hidden w-1/3 bg-gradient-to-l from-sky-200/40 to-transparent lg:block"></div>
                <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-2xl">
                        <p class="mb-3 inline-flex items-center rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">User Management</p>
                        <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Manage survey accounts with less friction.</h1>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-600 sm:text-base">Create new users, review account status, and keep access organized from one clean workspace.</p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('survey.register') }}" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/20 transition hover:-translate-y-0.5 hover:bg-slate-800">
                            <i class="material-icons text-base">person_add</i>
                            Create User
                        </a>
                        <a href="{{ route('survey.dashboard') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-50">
                            <i class="material-icons text-base">dashboard</i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>

                <div class="relative mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-medium text-slate-500">Total Users</p>
                        <p class="mt-2 text-3xl font-black text-slate-900">{{ $users->total() }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-medium text-slate-500">Active on Page</p>
                        <p class="mt-2 text-3xl font-black text-emerald-600">{{ $users->count() }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-medium text-slate-500">Current Role</p>
                        <p class="mt-2 text-3xl font-black text-sky-600">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-sm font-medium text-slate-500">View</p>
                        <p class="mt-2 text-3xl font-black text-violet-600">{{ $users->currentPage() }} / {{ $users->lastPage() }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
                <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Registered Users</h2>
                        <p class="mt-1 text-sm text-slate-500">Review status and role at a glance.</p>
                    </div>

                    <div class="flex items-center gap-2 rounded-2xl bg-slate-100 px-3 py-2 text-sm text-slate-600">
                        <i class="material-icons text-base text-slate-500">search</i>
                        <span>Tip: use the dashboard search to narrow results</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Role</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($users as $user)
                                <tr class="transition hover:bg-slate-50/80">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900 text-sm font-bold text-white">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ ucfirst($user->name) }}</p>
                                                <p class="text-xs text-slate-500">ID #{{ $user->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $status = strtolower($user->status ?? 'inactive');
                                            $statusClasses = $status === 'active'
                                                ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
                                                : 'bg-rose-50 text-rose-700 ring-rose-200';
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusClasses }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $role = strtolower($user->role ?? 'user');
                                            $roleClasses = match ($role) {
                                                'superadmin' => 'bg-violet-50 text-violet-700 ring-violet-200',
                                                'admin' => 'bg-sky-50 text-sky-700 ring-sky-200',
                                                default => 'bg-slate-100 text-slate-700 ring-slate-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $roleClasses }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button class="inline-flex items-center gap-1 rounded-full bg-slate-900 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">
                                                <i class="material-icons text-sm">edit</i>
                                                Edit
                                            </button>
                                            <form action="{{ route('survey.management', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 rounded-full bg-rose-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-rose-700" onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="material-icons text-sm">delete</i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-14 text-center text-sm text-slate-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col gap-3 border-t border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-500">Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users</p>
                    <div>
                        {{ $users->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>