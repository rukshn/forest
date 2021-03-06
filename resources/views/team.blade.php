<x-app-layout title="User Profile">
    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="capitalize text-lg font-bold">My Team</h1>
        </div>
    </header>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="my-4 grid grid-cols-10 gap-4">
                        <p class="col-span-2 font-bold">Name</p>
                        <p class="col-span-2 text-center font-bold">Asigned Tasks</p>
                        <p class="col-span-2 text-center font-bold">Tasks In Progress</p>
                        <p class="col-span-2 text-center font-bold">Completed Tasks</p>
                        <p class="col-span-2 text-center font-bold">Total Tasks</p>
                      @foreach ($team as $member)
                        <div class="col-span-2">
                          <a class="profile-link font-bold text-blue-600 hover:text-blue-700" href="/user/{{$member->user_id}}">
                            {{ $member->name }} @if($loop->index == 0) <span class="mx-2"> 🔥 <span> @endif
                          </a>
                        </div>
                        <div class="col-span-2">
                          <p class="text-center">@if ($member->asigned_tasks == null) 0 @else {{ $member->asigned_tasks }} @endif</p>
                        </div>
                        <div class="col-span-2">
                          <p class="text-center">@if ($member->in_progress_tasks == null) 0 @else {{ $member->in_progress_tasks }} @endif</p>
                        </div>
                        <div class="col-span-2">
                          <p class="text-center">@if ($member->completed_tasks == null) 0 @else {{ $member->completed_tasks }} @endif</p>
                        </div>
                        <div class="col-span-2">
                          <p class="text-center">@if ($member->completed_tasks == null) 0 @else {{ $member->total_tasks }} @endif</p>
                        </div>
                      @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
      .profile-link:before{
        content: '🧑‍💻';
        margin-right: 10px;
      }
    </style>
</x-app-layout>