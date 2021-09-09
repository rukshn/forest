<x-app-layout :title="$post->post_title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-1" x-data="reviewApp()">
                    @if (Session::has('message'))
                    <x-message>
                        {{ Session::get('message') }}
                    </x-message>
                    @endif

                    <div class="grid grid-cols-10 gap-3">
                        <div class="col-span-8">
                            <h1 class="text-3xl font-bold">
                                {{ $post->post_title }}
                            </h1>
                            <h2 class="text-xl text-gray-500 capitalize">
                                Please review task <a class="text-blue-500 hover:text-blue-600" href="/post/{{ $post->post_id }}">#{{ $post->post_id }}</a>
                            </h2>
                            <h3 class="text-lg text-gray-600 font-semibold">Requirements</h3>
                            <div class="content px-3 py-4" x-ref="postContent"
                                x-html='parseMarkdown(@json($post->post_content))''></div>
                        </div>
                        <div class="col-span-2 space-y-5">
                            <div>
                                <h3 class="text-gray-500 font-bold">Review progress</h3>
                                <span class="rounded-lg py-1 px-2 text-white font-bold text-sm"
                                    style="background-color: #{{$post->testing_state_color}}">{{ $post->testing_state_name }}</span>
                            </div>
                            <div class="space-y-3">
                                <h3 class="text-gray-500 font-bold">Complete review</h3>
                                <form action="/endpoint/review/complete" method="post">
                                    @csrf
                                    <input type="hidden" name="test_id" value="{{ $task_details->test_id }}">
                                    <input type="hidden" name="status" value="1">
                                    <button
                                        class="rounded-md px-2 w-full py-1.5 bg-green-500 text-gray-50 font-bold hover:bg-green-600 hover:text-white">
                                        <i class="bi bi-check-lg"></i> Review Passed
                                    </button>
                                </form>
                                <form action="/endpoint/review/complete" method="post">
                                    @csrf
                                    <input type="hidden" name="test_id" value="{{ $task_details->test_id }}">
                                    <input type="hidden" name="status" value="2">
                                    <button class="rounded-md w-full px-2 py-1.5 bg-red-500 text-gray-50 font-bold hover:bg-red-600 hover:text-white">
                                        <i class="bi bi-x-lg"></i> Review Failed
                                    </button>
                                </form>
                            </div>
                            <div>
                                <h3 class="text-gray-500 font-bold">Assigned users</h3>
                                @foreach ($assigned_users as $user)
                                    <p>
                                        {{ $user->user_name }}
                                    </p>
                                @endforeach
                            </div>
                            <div>
                                <h3 class="text-gray-500 font-bold">
                                    Reviewer
                                </h3>
                                <p>
                                    {{ $task_details->reviewer }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="my-2">
                            <button
                                class="rounded-md px-2 py-0.5 bg-gray-200 text-gray-400 hover:text-gray-600 hover:bg-gray-400 font-bold"
                                @click="open = ! open">Options</button>
                        </div>
                        <div class="flex space-x-6" x-show="open" x-transition>
                            <div class="flex-initial">
                                <form action="/endpoint/review/assign_user" method="post">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                                    <div class="py-3">
                                        <h3 class="font-bold text-gray-500">Assign reviewer</h3>
                                        <select name="user_id"
                                            class="w-auto h-10 border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
                                            @foreach ($users as $user)
                                            <option value="{{ $user->user_id}}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="buttons">
                                        <x-button class="w-full">
                                            {{__('Assign user')}}
                                        </x-button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>

            <div class="border-t-2 border-gray-300 relative py-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 space-y-1">
                        <h4 class="text-md font-semibold">Write comment</h4>
                        <form action="/endpoint/create_comment" method="POST" class="space-y-2">
                            @csrf
                            <input type="hidden" value="{{$post->post_id}}" name="post_id" />
                            <x-textarea class="w-full" name="comment"
                                placeholder="You can use markdown to format your comment"></x-textarea>
                            <x-button>
                                {{__('post comment')}}
                            </x-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/3.0.0/marked.min.js"
        integrity="sha512-+yBiQ6q3TDGoiassGMt28VYghfGBtA74mN2W8oNTCi49BsvmBfOSoMMGRj6TYRV7CF2URkpyS61uJBgC3H/uzA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dompurify/2.3.1/purify.min.js"
        integrity="sha512-S/PLyajatVDMRoX6YRLkZ83bPizWLo1MspY/ZgBNEujw39occlW8RxuBKn/NBDgrMXDsz0r3z4vj24reW4PvmQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function reviewApp() {
            return {
                content: '',
                open: false,
                parseMarkdown(inputMarkdown) {
                    const markdown = inputMarkdown
                    const dirtyHtml = marked(markdown)
                    const cleanHtml = DOMPurify.sanitize(dirtyHtml)
                    return cleanHtml
                }
            }
        }
    </script>
</x-app-layout>
