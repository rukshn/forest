<x-app-layout title="Dashboard">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="capitalize text-lg font-bold">Welcome {{ Auth()->user()->name }}</h1>
        </div>
    </header>

    <div class="py-6" x-data="homeApp()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <x-announcement
                :hasAnnouncement="$has_announcement ?? false"
                :title="$announcement->title ?? ''"
                :announcementId="$announcement->id ?? ''">
            </x-announcement>
            <div>
                <h1 class="text-gray-500 mb-2 font-bold text-xl">Milestones</h1>
                <div class="grid grid-cols-3 gap-4">
                    <div class="border-gray-400 border-2 border-dashed rounded-md py-4 px-3 cursor-pointer hover:border-gray-500">
                        <a href="/new/post"><h1 class="text-gray-500 font-bold text-xl hover:text-gray-700">➕New Milestone</h1></a>
                    </div>

                    @foreach ($milestones as $milestone)
                    <div class="bg-white rounded-md shadow-sm py-4 px-4 cursor-pointer">
                        <h1 class="text-gray-600 font-bold text-xl hover:text-gray-800">{{ $milestone->milestone }}</h1>
                    </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h1 class="text-gray-500 mb-3 font-bold text-xl">Latest Tasks</h1>
                <div class="grid grid-cols-3 gap-4">
                    @foreach ($tasks as $task)
                    <div class="rounded-md shadow-sm bg-white px-4 py-4">
                        <a href="/post/{{ $task->post_id }}">
                            <h1 class="text-xl mb-2 truncate text-gray-600 font-bold hover:text-indigo-800">{{ $task->post_title }}</h1>
                        </a>

                        <div class="grid grid-cols-4 gap-2 mb-2">
                            <span style="background-color: #{{$task->priority_color}}" class="block text-white text-sm font-bold py-0.5 px-3 rounded-md">
                                {{ $task->priority_code }}
                            </span>
                            <span style="background-color: #{{$task->status_color}}" class="block truncate text-white text-sm font-bold py-0.5 px-3 rounded-md">
                                {{ $task->status_name }}
                            </span>
                            <div></div>
                            <div class="col-span-2 lg:col-span-1 text-gray-500 text-sm"><i class="bi bi-chat mr-2"></i> {{ $task->comment_count }}</div>
                        </div>

                        <p class="text-gray-500 text-sm">By {{ $task->user_name }} on <span x-text="parseDate('{{ $task->post_date }}')"></span></p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h1 class="text-gray-500 mb-3 font-bold text-xl">Latest Issues</h1>
                <div class="grid grid-cols-3 gap-4">
                    @foreach ($issues as $issue)
                    <div class="rounded-md shadow-sm bg-white px-4 py-4">
                        <a href="/post/{{ $issue->post_id }}">
                            <h1 class="text-xl mb-2 truncate text-gray-600 font-bold hover:text-indigo-800">{{ $issue->post_title }}</h1>
                        </a>

                        <div class="grid grid-cols-4 gap-2 mb-2">
                            <span style="background-color: #{{$issue->priority_color}}" class="block text-white text-sm font-bold py-0.5 px-3 rounded-md">
                                {{ $issue->priority_code }}
                            </span>
                            <span style="background-color: #{{$issue->status_color}}" class="block truncate text-white text-sm font-bold py-0.5 px-3 rounded-md">
                                {{ $issue->status_name }}
                            </span>
                            <div></div>
                            <div class="col-span-2 lg:col-span-1 text-gray-500 text-sm"><i class="bi bi-chat mr-2"></i> {{ $issue->comment_count }}</div>
                        </div>

                        <p class="text-gray-500 text-sm">By {{ $issue->user_name }} on <span x-text="parseDate('{{ $issue->post_date }}')"></span></p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div>
                <h1 class="text-gray-500 mb-3 font-bold text-xl">Latest Review Requests</h1>
                <div class="grid grid-cols-3 gap-4">
                   @foreach ($reviews as $review)
                    <div class="rounded-md shadow-sm bg-white px-4 py-4">
                            <a href="/review/{{ $review->post_id }}">
                                <h1 class="text-xl mb-2 truncate text-gray-600 font-bold hover:text-indigo-800">{{ $review->post_title }}</h1>
                            </a>

                            <div class="grid grid-cols-4 gap-2 mb-2">
                                <span style="background-color: #{{$review->priority_color}}" class="block text-white text-sm font-bold py-0.5 px-3 rounded-md">
                                    {{ $review->priority_code }}
                                </span>
                                <span style="background-color: #{{$review->status_color}}" class="block truncate text-white text-sm font-bold py-0.5 px-3 rounded-md">
                                    {{ $review->status_name }}
                                </span>
                                <span style="background-color: #{{$review->testing_state_color}}" class="block truncate text-white text-sm font-bold py-0.5 px-3 rounded-md">
                                    {{ $review->testing_state_name }}
                                </span>
                                <div class="col-span-2 lg:col-span-1 text-gray-500 text-sm"><i class="bi bi-chat mr-2"></i> {{ $review->comment_count }}</div>
                            </div>

                            <p class="text-gray-500 text-sm">By {{ $review->user_name }} on <span x-text="parseDate('{{ $review->post_date }}')"></span></p>
                        </div>
                   @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        function homeApp() {
            return {
                parseDate(date) {
                    // Split timestamp into [ Y, M, D, h, m, s ]
                    const t = date.split(/[- :]/)
                    // Apply each element to the Date function
                    const d = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]))
                    const month = ("0" + (parseInt(d.getMonth()) + 1)).slice(-2)
                    const year = d.getFullYear()
                    const day = ("0" + d.getDate()).slice(-2)
                    return `${day}-${month}-${year}`
                },
            }
        }
    </script>
</x-app-layout>
