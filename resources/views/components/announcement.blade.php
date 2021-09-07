@if ($hasAnnouncement == true)
<div class="rounded-md space-y-2 mb-4 bg-indigo-100 px-3 py-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h1 class="font-bold py-2 text-xl">📣 Announcement - {{ $title ?? '' }}</h1>
    <div class="flex">
        <a class="bg-indigo-500 font-bold rounded-md px-2 py-1.5 text-gray-100 hover:text-white hover:bg-indigo-600"
            href="/announcement/{{ $announcementId }}">Read More</a>
    </div>
</div>
@endif
