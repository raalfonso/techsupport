<x-layout>
    <div class="min-h-screen flex bg-white items-center justify-center p-6">

        <div class="rounded-lg shadow w-full max-w-md mt-[0%] sm:mt-[-1/2]">
            <center>

                <img src="{{asset('img/itd_logo.png')}}" alt="" class="max-w-48 h-48 mx-auto mt-[-10%] mb-[-10%]">
            </center>

            <div class="mt-[-15%] p-6">
                <h1 class="text-2xl font-bold text-center mb-5 text-gray-800">ICTD Login</h1>
    
                <form action="{{ route('login')}}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block font-semibold text-gray-700">Email</label>
                        <input type="text" name="email" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-300 @error('email') ring-red-500 @enderror" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
        
                    <div class="mb-4">
                        <label for="password" class="block font-semibold text-gray-700">Password</label>
                        <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-300">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
        
                    <!-- Remember me checkbox -->
                    <div class="mb-4 flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        <label for="remember" class="text-gray-700">Remember me</label>
                    </div>
        
                    @error('failed')
                        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
                    @enderror
        
                    <button class="w-full px-4 py-3  bg-gradient-to-r from-slate-800 to-blue-950 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200">
                        Login
                    </button>
                </form>
            </div>
            
        </div>
    
    </div>
    
   
</x-layout>    

