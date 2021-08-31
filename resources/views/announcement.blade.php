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
                    @if (Session::has('error'))
                    <x-message>
                        {{ Session::get('error') }}
                    </x-message>
                    @endif
                    <div class="lg:grid lg:grid-cols-12 lg:gap-4">
                        <div class="py-2 space-y-1 col-span-9">
                            <div class="flex group space-x-2">
                                <h1 class="text-3xl flex-grow-0 font-bold">
                                    {{ $post->post_title }}</h1>
                                <form method="POST" action="/endpoint/announcement/archive">
                                    @csrf
                                    <input type="hidden" value="{{ $post->post_id }}" name="post_id" />
                                    <button type="submit" title="Unpin"
                                        class="rounded-md align-sub opacity-0 group-hover:opacity-40 hover:opacity-100 px-1 text-sm py-1 hover:text-gray-700 bg-gray-300 text-gray-500">
                                        <i class="bi bi-pin-fill"></i>
                                    </button>
                                </form>
                            </div>
                            <p class="text-sm font-light text-gray-500">{{ $post->user_name }} {{ $post->created_at}}
                            </p>
                            <div class="content px-3 py-4" x-ref="postContent"
                                x-html='parseMarkdown(@json($post->post_content))'>
                            </div>
                        </div>
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
    </script>
</x-app-layout>
