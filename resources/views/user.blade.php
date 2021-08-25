<x-app-layout title="User Profile">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Profile') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="title font-bold text-2xl capitalize">🧑‍💻 {{ $userData->user_name }}'s tasks</h1>
                    <div class="my-4 space-y-4">
                        @foreach ($asignments as $post)
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
    </div>
</x-app-layout>
