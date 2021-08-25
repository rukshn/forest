<x-app-layout title="Kanban">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-6 px-8" x-init="init" x-data="
    {
      tasks: [],
      todo: [],
      inprogress: [],
      done: [],
      loading: true,
      beginTask(item, index) {
        const task = this.todo[index]
        this.todo.splice(index,1)
        this.inprogress.push(task)
      },
      completeTask(item,index) {
        const task = this.inprogress[index]
        this.inprogress.splice(index,1)
        this.done.push(task)
      }
    }">
        <div class="grid grid-cols-3 gap-6">
            <div class="space-y-4">
                <h1 class="text-xl text-center font-bold">Todo</h1>
                <template x-for="(task, index) in todo">
                    <div class="rounded-md shadow-md px-6 py-4 bg-white">
                        <div class="grid grid-cols-8">
                            <div class="col-span-1">
                                <button @click="beginTask(task.task_id, index)"
                                    class="rounded-md px-2 py-1 bg-gray-200 font-bold text-gray-400 hover:text-gray-500">
                                    <i class="bi bi-check-circle-fill"></i>
                                </button>
                            </div>
                            <div class="col-span-7">
                                <a :href="bindLink(task.post_id)" class="text-lg font-bold"
                                    x-text="task.post_title"></a>
                                <div class="py-2 space-x-2">
                                    <span
                                        class="bg-red-200 border-2 rounded-md border-red-300 text-red-600 text-sm font-bold px-1 py-1"
                                        x-text="task.category_name"></span>
                                </div>
                                <div class="py-2 space-x-2">
                                    <p class="text-gray-400 font-light" x-text="task.date"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="space-y-4">
                <h1 class="text-xl text-center font-bold">In Progress</h1>
                <template x-for="(task,index) in inprogress">
                    <div class="rounded-md shadow-md px-6 py-4 bg-white">
                        <div class="grid grid-cols-8">
                            <div class="col-span-1">
                                <button @click="completeTask(task.task_id, index)"
                                    class="rounded-md px-2 py-1 bg-green-100 font-bold text-green-400 hover:text-green-500">
                                    <i class="bi bi-check-circle-fill"></i>
                                </button>
                            </div>
                            <div class="col-span-7">
                                <a :href="bindLink(task.post_id)" class="text-lg font-bold"
                                    x-text="task.post_title"></a>
                                <div class="py-2 space-x-2">
                                    <span
                                        class="bg-yellow-200 border-2 rounded-md border-yellow-300 text-yellow-600 text-sm font-bold px-1 py-1"
                                        x-text="task.category_name"></span>
                                </div>
                                <div class="py-2 space-x-2">
                                    <p class="text-gray-400 font-light" x-text="task.date"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="space-y-4">
                <h1 class="text-xl text-center font-bold">Completed</h1>
                <template x-for="task in done">
                    <div class="rounded-md shadow-md px-6 py-4 bg-white">
                        <div class="grid grid-cols-8">
                            <div class="col-span-1">
                                <button class="bg-green-700 text-white rounded-md px-2 py-1">
                                    <i class="bi bi-check-circle-fill"></i>
                                </button>
                            </div>
                            <div class="col-span-7">
                                <a :href="bindLink(task.post_id)" class="text-lg font-bold"
                                    x-text="task.post_title"></a>
                                <div class="py-2 space-x-2">
                                    <span
                                        class="bg-green-200 border-2 rounded-md border-green-300 text-green-600 text-sm font-bold px-1 py-1"
                                        x-text="task.category_name"></span>
                                </div>
                                <div class="py-2 space-x-2">
                                    <p class="text-gray-400 font-light" x-text="task.date"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
          </div>
          <template x-if="loading === true">
              <div class="bg-purple-200 rounded-md shadow-md py-4 max-w-6xl mx-auto">
                  <h1 class="text-center">Loading Kanban View</h1>
              </div>
          </template>
    </div>
    <script>
        function init() {
            const vm = this
            fetch('/api/kanban/tasks', {
                    method: 'GET',
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then((response) => response.json())
                .then((data) => {
                    vm.loading = false
                    data.forEach(task => {
                        if (task.status_code_id == 1) {
                            vm.todo.push(task)
                        } else if (task.status_code_id == 2) {
                            vm.inprogress.push(task)
                        } else if (task.status_code_id == 3) {
                            vm.done.push(task)
                        }
                    })
                })
        }

        function bindLink(id) {
            return `/post/${id}`
        }

    </script>
</x-app-layout>
