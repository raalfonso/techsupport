<x-layout>
    <h1 class="title">Login</h1>

    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('login')}}" method="post">
            @csrf
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" class="input @error('email') ring-red-500 @enderror" value="{{ old('email')}}">
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" class="input">
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- remember check box --}}
            <div class="mb-4">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </div>
            @error('failed')
                    <p class="error">{{ $message }}</p>
                @enderror
            <button class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Login
              </button>
        </form>
    </div>
</x-layout>    

