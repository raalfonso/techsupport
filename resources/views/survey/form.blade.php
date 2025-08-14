<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QR Code Generator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') <!-- Assuming you're using Vite with Tailwind -->
</head>
<body>

<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📝 Department Survey Form</h1>

    <p class="text-gray-600 mb-4">Department: <span class="font-semibold">{{ $department->title }}</span></p>

    <form action="{{ route('survey.submit', $department->id) }}" method="POST" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" id="name" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="email" id="email" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>

        <!-- Satisfaction Rating -->
        <div>
            <label for="rating" class="block text-sm font-medium text-gray-700">How satisfied are you with our services?</label>
            <select name="rating" id="rating" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Select a rating</option>
                <option value="5">Very Satisfied</option>
                <option value="4">Satisfied</option>
                <option value="3">Neutral</option>
                <option value="2">Unsatisfied</option>
                <option value="1">Very Unsatisfied</option>
            </select>
        </div>

        <!-- Comments -->
        <div>
            <label for="comments" class="block text-sm font-medium text-gray-700">Additional Comments</label>
            <textarea name="comments" id="comments" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Share your thoughts..."></textarea>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit"
                class="w-full bg-indigo-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                Submit Survey
            </button>
        </div>
    </form>
</div>
</body>
</html>