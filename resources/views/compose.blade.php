<x-app-layout title="Create new post">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Post') }}
        </h2>
    </x-slot>

    <div class="py-8" x-data="composeApp()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="title font-bold text-2xl">Create New Post</h1>
                    <h2 class="subtitle font-semibold text-lg text-gray-500">Create a new issue, add milestone, create
                        task etc</h2>

                    @if (Session::has('error'))
                        <x-message>
                            {{ Session::get('error') }}
                        </x-message>
                    @endif

                    @if (Session::has('message'))
                    <x-message>
                        {{ Session::get('message') }}
                    </x-message>
                    @endif

                    <form action="/endpoint/new/post" method="POST">
                        @csrf
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" placeholder="Post title"
                            required autocomplete="off" />

                        <x-textarea rows="10" class="w-full mt-2" name="post" placeholder="Use markdown to format your text" />

                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <h3 class="font-bold text-gray-500">
                                    Category
                                </h3>
                                <select x-model="category" name="category"
                                    class="w-full border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
                                    <option value="1">Issue</option>
                                    <option value="2">Task</option>
                                    <option value="3">Milestone</option>
                                </select>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-500">Priority</h3>
                                <select name="priority"
                                class="w-full h-10 border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1"
                                >
                                    <option value="1">Lowest</option>
                                    <option value="2">Low</option>
                                    <option selected value="3">Medium</option>
                                    <option value="4">High</option>
                                    <option value="5">Highest</option>
                                </select>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-500">
                                    Deadline
                                </h3>
                                <input type="date" name="deadline"
                                            class="w-full h-10 border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1"
                                        >
                            </div>
                            <div x-show="category != 3" x-transition>
                                <h3 class="font-bold text-gray-500">
                                    Milestone
                                </h3>
                                <select name="milestone"
                                    class="w-full h-10 border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
                                    <option disabled selected value="0">Select milestone</option>
                                    @foreach ($milestones as $milestone)
                                    <option value="{{ $milestone->milestone_id }}">{{ $milestone->milestone }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="buttons mt-2">
                            <x-button>
                                {{__('Post')}}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function composeApp() {
            return {
                category: 1
            }
        }
    </script>
</x-app-layout>
