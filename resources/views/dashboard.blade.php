<x-app-layout title="Dashboard">
    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="capitalize text-lg font-bold">{{ Route::current()->getName() }}</h1>
        </div>
    </header>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-announcement
                :hasAnnouncement="$has_announcement"
                :title="$announcement->title ?? ''"
                :announcementId="$announcement->id ?? ''">
            </x-announcement>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-2">
                    @foreach ($feed as $post)
                        <x-card
                            :title="$post->post_title"
                            :author="$post->user_name"
                            :category="$post->category_name"
                            :date="$post->post_date"
                            :ccolor="$post->category_color"
                            :status="$post->status_name"
                            :pid="$post->post_id"
                            :scolor="$post->status_color"
                            :comments="$post->comment_count" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
