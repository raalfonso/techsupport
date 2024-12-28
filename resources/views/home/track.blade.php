<x-layout>
    <style>
        .loader {
  width: 16px;
  height: 16px;
  position: relative;
  left: -32px;
  border-radius: 50%;
  color: #fff;
  background: currentColor;
  box-shadow: 32px 0 , -32px 0 ,  64px 0;
}

.loader::after {
  content: '';
  position: absolute;
  left: -32px;
  top: 0;
  width: 16px;
  height: 16px;
  border-radius: 10px;
  background:#FF3D00;
  animation: move 3s linear infinite alternate;
}

@keyframes move {
  0% , 5%{
    left: -32px;
    width: 16px;
  }
  15% , 20%{
    left: -32px;
    width: 48px;
  }
  30% , 35%{
    left: 0px;
    width: 16px;
  }
  45% , 50%{
    left: 0px;
    width: 48px;
  }
  60% , 65%{
    left: 32px;
    width: 16px;
  }

  75% , 80% {
    left: 32px;
    width: 48px;
  }
  95%, 100% {
    left: 64px;
    width: 16px;
  }
}
    </style>

<div class="container mx-auto w-full p-4 flex justify-center ">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-700 mb-6 text-center">Track Your Ticket</h1>
        <form action="{{ route('home.track-view')}}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="ticket_number" class="block text-sm font-medium text-gray-600">Ticket Number</label>
                <input type="text" id="ticket_number" name="ticket_number"
                    class="w-full mt-1 p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your ticket number" required>
                @error('ticket_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full bg-yellow-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-yellow-600 focus:ring focus:ring-yellow-300">
                Track
            </button>
        </form>
    </div>



</div>

 </x-layout>    
 
 