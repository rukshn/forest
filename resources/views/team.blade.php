<x-app-layout title="User Profile">
    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="capitalize text-lg font-bold">Team</h1>
        </div>
    </header>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="my-4 space-y-4">
                      <ul>
                      @foreach ($team as $member)
                        <li class="left-4 profile-link space-x-2 font-bold">
                          <a class="text-blue-600 hover:text-blue-700" href="/user/{{$member->id}}">{{ $member->name }}</a>
                        </li>
                      @endforeach
                      <ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
      .profile-link:before{
        content: '🧑‍💻'
      }
    </style>
</x-app-layout>