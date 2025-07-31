<x-layout>
  <style>
    body{
        background: linear-gradient(to bottom left, #00cb6a, #4dc9fe);
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
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

        /* Next & previous buttons */
        .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -22px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
        }

        /* Position the "next button" to the right */
        .next {
        right: 0;
        border-radius: 3px 0 0 3px;
        }

        /* On hover, add a black background color with a little bit see-through */
        .prev:hover, .next:hover {
        background-color: rgba(0,0,0,0.8);
        }

        /* Caption text */
        .text {
        color: #f2f2f2;
        font-size: 15px;
        padding: 8px 12px;
        position: absolute;
        bottom: 8px;
        width: 100%;
        text-align: center;
        }

        /* Number text (1/3 etc) */
        .numbertext {
        color: #f2f2f2;
        font-size: 12px;
        padding: 8px 12px;
        position: absolute;
        top: 0;
        }

        /* The dots/bullets/indicators */
        .dot {
        cursor: pointer;
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
        }

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

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-0">
    <div class=" text-white p-10">
        <div class="ml-56">
            <center><img src="{{asset('images/logo.png')}}" alt="" class="max-w-80">
                {{-- <p class="text-blue-900 text-lg font-bold">Sign in to the SolveIT</p> --}}
           
            </center> 
            <form action="{{ route('client.login.submit')}}" method="post">
                @csrf
                <div class="mb-5 max-w-96">
                    <label for="email" class="text-lg font-bold text-slate-700">Email Address</label>
                    <input type="text" id="auto-suggest" name="email_address" class="input @error('email_address') ring-red-500 @enderror" placeholder="Type to search..." autocomplete="off">
                    <div id="suggestions" class="suggestions-box"></div>
                    @error('email_address')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <button class="max-w-96 w-full px-4 py-2 bg-gradient-to-r from-slate-800 to-blue-950 text-white font-semibold rounded hover:from-slate-700 hover:to-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-500">
                    Login
                  </button>
                  
            </form>
    
        </div>
    </div>
        
    <div id="default-carousel" class="relative mx-auto" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="slideshow-container">
    
            <div class="mySlides fade">
                <img src="{{ asset('images/zoom.png') }}" alt="" class="w-full max-w-max max-h-screen">
            </div>
    
            <div class="mySlides fade">
                <img src="{{ asset('images/gmeet.png') }}" alt="" class="w-full max-w-max max-h-screen">
            </div>
    
        </div>
    
        <br>
    
        <div class="text-center">
            <span class="dot cursor-pointer" onclick="currentSlide(1)"></span> 
            <span class="dot cursor-pointer" onclick="currentSlide(2)"></span> 
        </div>
    </div>
        
</div>
  


























<script>
    document.getElementById('auto-suggest').addEventListener('input', function () {
    const query = this.value;
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
                        suggestion.addEventListener('click', () => {
                            document.getElementById('auto-suggest').value = item.email_address;
                            suggestionsBox.style.display = 'none';
                        });
                        suggestionsBox.appendChild(suggestion);
                    });
                } else {
                    suggestionsBox.style.display = 'none';
                }
            });
    } else {
        document.getElementById('suggestions').style.display = 'none';
    }
});





let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}





</script>
</x-layout>    

