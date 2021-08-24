<x-app-layout :title="$post->post_title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{content: ''}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-1">
                    @if (Session::has('message'))
                    <x-message>
                        {{ Session::get('message') }}
                    </x-message>
                    @endif
                    <div class="grid grid-cols-12 gap-4">
                        <div class="py-2 space-y-1 col-span-9">
                            <h1 class="text-3xl font-bold">{{ $post->post_title }}</h1>
                            <p class="text-sm font-light text-gray-500">{{ $post->user_name }} {{ $post->created_at}}</p>
                            <div class="content px-3 py-4" x-ref="postContent" x-html='parseMarkdown(@json($post->post_content))'></div>
                        </div>
                        <div class="col-span-3">
                            <div>
                                <h3 class="text-gray-500 mb-2">Tags</h3>
                                <span class="rounded-lg py-1 px-2 text-white font-bold text-sm"
                                    style="background-color: #{{$post->category_color}}">{{ $post->category_name }}</span>
                                <span class="rounded-lg py-1 px-2 text-white font-bold text-sm"
                                    style="background-color: #{{$post->status_color}}">{{ $post->status_name }}</span>
                            </div>
                            <div>
                                <h3 class="text-gray-500 mt-3 mb-2">Assigned to</h3>
                                @foreach ($asigns as $asign)
                                    <sapn id="as-user-{{ $loop->index }}" class="group rounded-md bg-gray-200 text-gray-600 px-2 py-1 space-x-2 space-y-2">
                                        {{ $asign->user_name }}
                                        <button @click="removeUser({{ $loop->index }}, {{ $asign->user_id }}, {{ $post->post_id }})" class="px-1 opacity-0 group-hover:opacity-100"><i class="bi bi-trash"></i></button>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class="flex-initial">
                            <form action="/endpoint/change_status" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{$post->post_id}}">
                                <div class="py-3">
                                    <h3 class="font-bold text-gray-500">Change status</h3>
                                    <select name="status"
                                        class="w-full border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
                                        <option value="1">Todo</option>
                                        <option value="2">In progress</option>
                                        <option value="3">Completed</option>
                                    </select>
                                </div>
                                <div class="buttons" type="submit">
                                    <x-button class="w-full">
                                        {{__('Change status')}}
                                    </x-button>
                                </div>
                            </form>
                        </div>
                        <div class="flex-initial">
                            <form action="/endpoint/asign_user" method="post">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                                <div class="py-3">
                                    <h3 class="font-bold text-gray-500">Assign user</h3>
                                    <select name="user_id"
                                        class="w-auto border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
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

            @foreach ($comments as $comment)
            <div class="comment-block relative left-4 py-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative -left-4">
                    <h4 class="text-sm px-4 py-2 bg-green-100 font-bold">{{ $comment->username }}
                        <span class="text-gray-600 text-sm font-normal">{{ $comment->created_at }}
                        </span>
                        @if ($comment->user_id == $post->user_id)
                        <span class="text-green-600 rounded-md border border-green-500 px-2 float-right">
                            Author
                        </span>
                        @endif
                    </h4>
                    <div class="px-6 py-3 bg-white border-b border-gray-200 space-y-1">
                        <div class="my-2 content" x-html='parseMarkdown(@json($comment->comment))'></div>
                    </div>
                </div>
            </div>
            @endforeach

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

        function parseMarkdown(inputMarkdown) {
            const markdown = inputMarkdown
            const dirtyHtml = marked(markdown)
            const cleanHtml = DOMPurify.sanitize(dirtyHtml)
            return cleanHtml
        }

        function removeUser(e,user_id, post_id) {

            if (document.querySelector(`#as-user-${e}`)) {
                document.querySelector(`#as-user-${e}`).classList.add('hidden')
            }

            fetch ('/endpoint/unasign_user', {
                method: "POST",
                headers: {
                    'content-type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    user_id: user_id,
                    post_id: post_id
                })
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 200) {

                } else {

                }
            })
            .catch((e) => {

            })
        }

    </script>

    <style>
        .comment-block:before {
            --tw-border-opacity: 1;
            background-color: rgba(209, 213, 219, var(--tw-border-opacity));
            bottom: 0;
            content: "";
            display: block;
            left: 0;
            position: absolute;
            top: 0;
            width: 2px;
        }

    </style>
</x-app-layout>
