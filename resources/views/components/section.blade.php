<!-- resources/views/components/section.blade.php -->
@props(['title'])
<div class="bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-3xl font-semibold">{{ $title }}</h2>
    <p class="text-gray-700">{{ $content }}</p>
</div>