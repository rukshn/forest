<x-app-layout title="Create new post">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Announcement') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="title font-bold text-2xl">Create New Announcement</h1>
                    <h2 class="subtitle font-semibold text-lg text-gray-500">Announcements can broadcast a message to the whole team</h2>

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

                    <form action="/endpoint/new/announcement" method="POST">
                        @csrf
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" placeholder="Post title"
                            required autocomplete="off" />

                        <x-textarea rows="8" class="w-full mt-2" name="announcement" placeholder="Use markdown to format your text" />

                        <select name="is_pinned"
                            class="w-full border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
                            <option value="1">Pin</option>
                            <option value="0">Don't pin</option>
                        </select>

                        <div class="buttons mt-2">
                            <x-button>
                                {{__('Announce')}}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
