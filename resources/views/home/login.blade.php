<x-layout>
    <style>
         * {box-sizing: border-box}
        body {font-family: Verdana, sans-serif; margin:0}
        .mySlides {display: none}
        img {vertical-align: middle;}

        /* Slideshow container */
        .slideshow-container {
        max-width: 1000px;
        position: relative;
        margin: auto;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover, .next:hover {
        background-color: rgba(0,0,0,0.8);
        }


        /* The dots/bullets/indicators */
    
        .active, .dot:hover {
        background-color: #717171;
        }

        /* Fading animation */
        .fade {
        animation-name: fade;
        animation-duration: 1.5s;
        }

        @keyframes fade {
        from {opacity: .4} 
        to {opacity: 1}
        }

        /* On smaller screens, decrease text size */
        @media only screen and (max-width: 300px) {
        .prev, .next,.text {font-size: 11px}
        }
    </style>
<div class="flex flex-col md:flex-row h-screen">
    <!-- Left Half (With Background) -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-6" style="background: linear-gradient(to bottom left, #00cb6a, #4dc9fe); background-repeat: no-repeat;">
        <img src="{{asset('images/logo.png')}}" alt="" class="max-w-80 mb-1 lg:mt-[-25%]">
        
        <form action="{{ route('client.login.submit')}}" method="post" class="w-full max-w-md">
            @csrf
            <div class="mb-5">
                <label for="email" class="text-lg font-bold text-slate-700">Email Address</label>
                <input type="text" id="auto-suggest" name="email_address" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-300 @error('email_address') ring-red-500 @enderror" placeholder="Type to search..." autocomplete="off">
                <div id="suggestions" class="suggestions-box"></div>
                @error('email_address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button class="w-full px-4 py-3 bg-gradient-to-r from-slate-800 to-blue-950 text-white font-semibold rounded-md hover:from-slate-700 hover:to-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-500 transition duration-200">
                Login
            </button>
        </form>
    </div>

    <!-- Right Half (With Carousel) -->
    <div class="w-full md:w-1/2 flex justify-center items-center p-6" style="background: linear-gradient(to bottom left, #0a0684, #4dc9fe); background-repeat: no-repeat;">
        <div id="default-carousel" class="relative mx-auto w-full max-w-lg" data-carousel="slide">
            <!-- Carousel Wrapper -->
            <div class="slideshow-container">
                <div class="mySlides fade ml-10">
                    <img src="{{ asset('images/zoom (2).png') }}" alt="" class="w-full max-w-max max-h-screen">
                </div>

                <div class="mySlides fade ml-10">
                    <img src="{{ asset('images/gmeet (2).png') }}" alt="" class="w-full max-w-max max-h-screen">
                </div>
            </div>
        </div>
    </div>
</div>

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  


<script>
//     document.getElementById('auto-suggest').addEventListener('input', function () {
//     const query = this.value;
//         console.log(query);
//     if (query.length >= 3) {
//         fetch(`/search-suggestions?q=${encodeURIComponent(query)}`)
//             .then(response => response.json())
//             .then(data => {
//                 const suggestionsBox = document.getElementById('suggestions');
//                 suggestionsBox.innerHTML = '';

//                 if (data.length) {
//                     suggestionsBox.style.display = 'block';
//                     data.forEach(item => {
//                         const suggestion = document.createElement('div');
//                         suggestion.textContent = item.email_address; // Adjust based on your data structure
//                         suggestion.addEventListener('click', () => {
//                             document.getElementById('auto-suggest').value = item.email_address;
//                             suggestionsBox.style.display = 'none';
//                         });
//                         suggestionsBox.appendChild(suggestion);
//                     });
//                 } else {
//                     suggestionsBox.style.display = 'none';
//                 }
//             });
//     } else {
//         document.getElementById('suggestions').style.display = 'none';
//     }
// });
document.getElementById('auto-suggest').addEventListener('input', function () {
    const query = this.value.trim();
    console.log(query);

    if (query.length >= 3) {
        fetch(`/search-suggestions?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                const suggestionsBox = document.getElementById('suggestions');
                suggestionsBox.innerHTML = '';

                if (data.length) {
                    suggestionsBox.style.display = 'block';

                    data.forEach(item => {
                        const suggestion = document.createElement('div');
                        suggestion.textContent = item.email_address; // Adjust based on your data structure

                        // Apply Tailwind classes for styling
                        suggestion.className = "border border-slate-500 p-2 mb-0 rounded-md bg-white hover:bg-slate-400 cursor-pointer transition duration-200";

                        // Click event to select the suggestion
                        suggestion.addEventListener('click', () => {
                            document.getElementById('auto-suggest').value = item.email_address;
                            suggestionsBox.style.display = 'none';
                        });

                        suggestionsBox.appendChild(suggestion);
                    });
                } else {
                    suggestionsBox.style.display = 'none';
                }
            })
            .catch(error => console.error("Error fetching suggestions:", error));
    } else {
        document.getElementById('suggestions').style.display = 'none';
    }
});


    let slideIndex = 0;

    function showSlides() {
        let slides = document.getElementsByClassName("mySlides");
        
        // Hide all slides
        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        // Increment slide index and reset if necessary
        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }

        // Show the current slide
        slides[slideIndex - 1].style.display = "block";

        // Change slide every 5 seconds
        setTimeout(showSlides, 5000);
    }

    // Start the slideshow when the page loads
    document.addEventListener("DOMContentLoaded", showSlides);


</script>
</x-layout>   