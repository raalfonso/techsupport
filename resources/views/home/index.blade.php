<x-layout>
    <div class="container mx-auto px-4"  x-data="{ showModal: false,}">
        <div class="flex">
            <!-- Left Column -->
            <div class="w-2/6 max-w-fit mt-12">
                <!-- Content for the 3-column width -->
                <img src="{{ asset('images/rb_2148887720.png') }}" alt="Example Image" class="w-[644px] h-[400px]">

            </div>
    
            <!-- Right Column -->
            <div class="w-3/4 ml-20">
                <!-- First Row -->
                <div class="flex space-x-4">
                    <div class="relative max-w-sm max-h-[100%] p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Setup</h5>
                        </a>
                    
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            <ul class="max-w-md pb-5 mb-5 space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                                <li>TV</li>
                                <li>Zoom</li>
                                <li>Google meet</li>
                                <li>Projector</li>
                                <li>others</li>
                            </ul>
                        </p>
                        
                        <a href="{{ route('home.add',['id'=>'1'])}}" class="report-btn absolute bottom-2 max-h-max inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Report 
                            <i class="material-icons ml-16">report</i>
                        </a>
                    </div>
                    <div class="relative max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Acumatica</h5>
                        </a>
                        <ul class="max-w-md pb-5 mb-5 space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                            <li>Forgot password</li>
                            <li>Reset password</li>
                            <li>OIC Designation</li>
                            <li>Deletion</li>
                            <li>others</li>
                        </ul>
                        <a href="{{ route('home.add',['id'=>'2'])}}" class="report-btn absolute bottom-2 max-h-max inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Report 
                            <i class="material-icons ml-16">report</i>
                        </a>
                    </div>
                    <div class="relative max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Security</h5>
                        </a>
                        <ul class="max-w-md pb-5 mb-5 space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                            <li>Malware Detection</li>
                            <li>Phishing Detection</li>
                            <li>others</li>
                        </ul>
                        <a href="{{ route('home.add',['id'=>'3'])}}" class="report-btn absolute bottom-2 max-h-max inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Report 
                            <i class="material-icons ml-16">report</i>
                        </a>
                    </div>
                </div>
    
                <!-- Second Row -->
                <div class="flex space-x-4 mt-4">
                    <div class="relative max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Printer</h5>
                        </a>
                        <ul class="max-w-md pb-5 mb-5 space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                            <li>Setup</li>
                            <li>Empty toner</li>
                            <li>Paper jam</li>
                            <li>Offline</li>
                            <li>Reboot</li>
                            <li>others</li>
                        </ul>
                        <a href="{{ route('home.add',['id'=>'4'])}}" class="report-btn absolute bottom-2 max-h-max inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Report 
                            <i class="material-icons ml-16">report</i>
                        </a>
                    </div>
                    <div class="relative max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Repair</h5>
                        </a>
                        <ul class="max-w-md pb-5 mb-5 space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                            <li>Laptop</li>
                            <li>PC</li>
                            <li>Ipad</li>
                            <li>Projector</li>
                            <li>others</li>
                        </ul>
                        <a href="{{ route('home.add',['id'=>'5'])}}" class="report-btn absolute bottom-2 max-h-max inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Report 
                            <i class="material-icons ml-16">report</i>
                        </a>
                    </div>
                    <div class="relative max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52">
                        <a href="#">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Others</h5>
                        </a>
                        {{-- <ul class="max-w-md pb-5 mb-5 space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                            <li>Laptop</li>
                            <li>PC</li>
                            <li>Ipad</li>
                            <li>Projector</li>
                            <li>others</li>
                        </ul> --}}
                        <a href="{{ route('home.add',['id'=>'6'])}}" class="report-btn absolute bottom-2 max-h-max inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                            Report 
                            <i class="material-icons ml-16">report</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div x-show="showModal"  class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center"x-cloak>
            <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold">Report Issues</h2>
                    <button @click="showModal = false" class="text-gray-600 hover:text-gray-800">&times;</button>
                </div>
                <div class="content-form">
                    
                </div>
                             
            </div>
        </div>
    </div>
    
</x-layout>    
