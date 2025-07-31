<x-layout>
    <div class="min-h-screen items-center justify-center p-6" style="background: linear-gradient(to bottom left, #00cb6a, #4dc9fe); background-repeat: no-repeat; background-attachment: fixed;">
   
    <div class="mx-auto max-w-screen-sm card mt-5">
        <form action="{{ route('register')}}" method="post">
            @csrf
            <h1 class="title">Register a new account</h1>

            <div class="mb-4">
                <label for="name">Name</label>
                <input type="text" name="name" class="input @error('name') ring-red-500 @enderror" value="{{ old('name')}}">
                @error('name')
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
                <label for="level">Level</label>
                <input type="text" name="level" class="input" value="{{ old('level')}}">
                @error('level')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="team">Team</label>
                <select name="team" id="team" class="input">
                    <option value="">Select team</option>
                    <option value="Systems">Systems</option>
                    <option value="NIS">NIS</option>
                    <option value="Admin">Admin</option>
                </select>
                @error('issues_id')
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
    </div>
</x-layout>    

