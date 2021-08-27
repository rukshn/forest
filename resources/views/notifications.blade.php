<x-app-layout title="Notifications">
    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="capitalize text-lg font-bold">{{ Route::current()->getName() }} Center</h1>
        </div>
    </header>

    <div class="py-6" x-data="{}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-3">
            @foreach ($notifications as $notification)
            <div class="px-4 py-3 rounded-md shadow-md @if($notification->has_opened == false) bg-purple-50 hover:bg-white @else bg-white @endif">
                <div class="flex items-baseline">
                    <span class="mr-3">
                        @if ($notification->notification_type == 'task')
                          🧤
                        @endif
                        @if ($notification->notification_type == 'comment')
                          💬
                        @endif
                    </span>
                    <a class="flex-grow mr-3" href="/post/{{$notification->post_id}}"> {{ $notification->message }}</a>
                    <button @click="readNotification({{$notification->id}})"
                        class="bg-gray-200 text-gray-500 hover:text-gray-600 rounded-md px-1 py-1">
                        <i class="bi bi-check-circle-fill"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
      function readNotification(notificationId) {
        fetch('/endpoint/notification/read', {
          method: 'POST',
          headers: {
            'content-type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            notification_id: notificationId
          })
        })
      }
    </script>
</x-app-layout>
