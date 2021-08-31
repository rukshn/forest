@if ($has_announcement == true)
<div class="rounded-md mb-4 bg-indigo-400 text-white px-3 py-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
    <h1 class="font-bold py-2 text-xl">📣 Announcement - {{ $title }}</h1>
    <a class="bg-indigo-600 rounded-md px-2 py-1 text-gray-100 hover:text-white hover:bg-indigo-800" href="/announcement/{{ $announcement_id }}">Read More</a>
</div>
@endif