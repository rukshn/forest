<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Post') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                  <h1 class="title font-bold text-2xl">Create New Post</h1>
                  <h2 class="subtitle font-semibold text-lg text-gray-500">Create a new issue, add milestone, create task etc</h2>

                  <form action="/endpoint/compose" method="POST">
										@csrf
										<x-input id="title" class="block mt-1 w-full"
																	type="text"
																	name="title"
																	placeholder="Post title"
																	required autocomplete="off" />

										<x-textarea class="w-full mt-2" name="post" placeholder="Use markdown to format your text" />

										<select class="w-full border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
											<option value="">Issue</option>
											<option value="">Task</option>
											<option value="">Milestone</option>
										</select>

										<div class="buttons mt-2">
											<button class="px-3 rounded-md py-2 bg-blue-600 text-white font-bold hover:bg-blue-700 focus:outline-none">Post</button>
										</div>
									</form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
