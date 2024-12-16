<x-layout>
    <h1 class="title">Register a new account</h1>

    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('register')}}" method="post">
            @csrf
            <div class="mb-4">
                <label for="username">Username</label>
                <input type="text" name="username" class="input @error('username') ring-red-500 @enderror" value="{{ old('username')}}">
                @error('username')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" class="input" value="{{ old('email')}}">
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

            <div class="mb-4">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="input">
                
            </div>

           
            <button class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Register
              </button>
        </form>
    </div>
</x-layout>    

