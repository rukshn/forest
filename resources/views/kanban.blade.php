<x-app-layout title="Kanban">
    <div x-data="kanbanApp()">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-3 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-4 gap-4">
                    <div class="col-span-1">
                        <label class="block font-bold text-sm text-gray-500" for="milestone">Milestone</label>
                        <select
                            class="w-full h-10 border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1"
                            @change="sortByMilestone" x-model="selectedMilestone" id="milestone">
                            <option value="all" selected>All</option>
                            @foreach($milestones as $milestone)
                            <option value="{{ $milestone->milestone_id }}" class="truncate">{{ $milestone->milestone }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label for="priority" class="block font-bold text-sm text-gray-500">Priority</label>
                        <select
                            class="h-10 border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1"
                            @change="sortByPriority" x-model="selectedPriority" id="priority">
                            <option value="chron">Chronological</option>
                            <option value="asc">Lowest first</option>
                            <option value="desc">Highest first</option>
                        </select>
                    </div>
                </div>
            </div>
        </header>
        <div class="py-6 px-8">
            <div class="grid grid-cols-3 gap-6">
                <div class="space-y-4">
                    <h1 class="text-xl text-center font-bold">Todo</h1>
                    <template x-for="(task, index) in filteredTodo">
                        <div class="rounded-md shadow-md px-6 py-4 bg-white">
                            <div class="grid grid-cols-8">
                                <div class="col-span-1">
                                    <button @click="beginTask(task.post_id, index, task.post_status_id)"
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
                                        <span
                                            class="border-2 rounded-md border-transparent text-white text-sm font-bold px-1 py-1 capitalize"
                                            :style="{ backgroundColor: '#' + task.priority_color }" x-text="task.priority_code"></span>
                                    </div>
                                    <div class="py-2 space-x-2 grid grid-cols-2 gap-2">
                                        <div class="col-span-1"><p class="text-gray-400 font-light" x-text="setDeadlineText(task.deadline)"></p></div>
                                        <div class="col-span-1">
                                            <p class="text-gray-400 font-light" x-text="parseName(task.asigned_user)"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="space-y-4">
                    <h1 class="text-xl text-center font-bold">In Progress</h1>
                    <template x-for="(task,index) in filteredInprogress">
                        <div class="rounded-md shadow-md px-6 py-4 bg-white">
                            <div class="grid grid-cols-8">
                                <div class="col-span-1">
                                    <button @click="completeTask(task.post_id, index, task.post_status_id)"
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
                                        <span
                                            class="border-2 rounded-md border-transparent text-white text-sm font-bold px-1 py-1 capitalize"
                                            :style="{ backgroundColor: '#' + task.priority_color }" x-text="task.priority_code"></span>
                                    </div>
                                    <div class="py-2 space-x-2 grid grid-cols-2 gap-2">
                                        <div class="col-span-1"><p class="text-gray-400 font-light" x-text="setDeadlineText(task.deadline)"></p></div>
                                        <div class="col-span-1">
                                            <p class="text-gray-400 font-light" x-text="parseName(task.asigned_user)"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="space-y-4">
                    <h1 class="text-xl text-center font-bold">Completed</h1>
                    <template x-for="task in filteredDone">
                        <div class="rounded-md shadow-md px-6 py-4 bg-white">
                            <div class="grid grid-cols-8">
                                <div class="col-span-1">
                                    <button @click="archieveTask(task.post_id, index)" class="bg-green-700 hover:bg-blue-700 text-white rounded-md px-2 py-1">
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
                                        <span
                                            class="border-2 rounded-md border-white text-white text-sm font-bold px-1 py-1 capitalize"
                                            :style="{ backgroundColor: '#' + task.priority_color }" x-text="task.priority_code"></span>
                                    </div>
                                    <div class="py-2 space-x-2 grid grid-cols-2 gap-2">
                                        <div class="col-span-1"><p class="text-gray-400 font-light" x-text="setDeadlineText(task.deadline)"></p></div>
                                        <div class="col-span-1">
                                            <p class="text-gray-400 font-light" x-text="parseName(task.asigned_user)"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
              </div>
              <template x-if="loading === true">
                  <div class="bg-purple-200 rounded-md shadow-md py-4 max-w-6xl my-6 mx-auto">
                      <h1 class="text-center" x-text="notification_message"></h1>
                  </div>
              </template>
        </div>
    </div>
    <script>
        function bindLink(id) {
            return `/post/${id}`
        }

        function kanbanApp() {
          return {
            tasks: [],
            todo: [],
            filteredTodo: [],
            inprogress: [],
            filteredInprogress: [],
            done: [],
            filteredDone: [],
            loading: true,
            notification_message: "Loading Kanban Board",
            selectedMilestone: null,
            selectedPriority: null,
            init() {
                const vm = this
                fetch('/endpoint/kanban/tasks', {
                        method: 'GET',
                        headers: {
                            Accept: 'application/json'
                        }
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        vm.loading = false
                        vm.tasks = data
                        data.forEach(task => {
                            if (task.status_code_id == 1) {
                                vm.todo.push(task)
                            } else if (task.status_code_id == 2) {
                                vm.inprogress.push(task)
                            } else if (task.status_code_id == 3) {
                                vm.done.push(task)
                            }
                        })

                        vm.filteredTodo = vm.todo
                        vm.filteredInprogress = vm.inprogress
                        vm.filteredDone = vm.done
                    })
                    .catch((e) => {
                    vm.notification_message = "Error loading Kanban"
                    })
            },
            sortByMilestone() {
                const milestone = this.selectedMilestone

                if (milestone === "all") {
                    this.filteredTodo = this.todo
                    this.filteredInprogress = this.inprogress
                    this.filteredDone = this.done
                } else {
                    this.filteredTodo = this.todo.filter(item => item.milestone_id == milestone)
                    this.filteredInprogress = this.inprogress.filter(item => item.milestone_id == milestone)
                    this.filteredDone = this.done.filter(item => item.milestone_id == milestone )
                }
            },
            sortByPriority() {
                if (this.selectedPriority === "asc") {
                    this.filteredTodo.sort((a,b) => {
                        return parseInt(a.priority)-parseInt(b.priority)
                    })

                    this.filteredInprogress.sort((a,b) => {
                        return parseInt(a.priority)-parseInt(b.priority)
                    })

                    this.filteredDone.sort((a,b) => {
                        return parseInt(a.priority)-parseInt(b.priority)
                    })
                } else if (this.selectedPriority === "desc") {
                    this.filteredTodo.sort((a,b) => {
                        return parseInt(b.priority)-parseInt(a.priority)
                    })

                    this.filteredInprogress.sort((a,b) => {
                        return parseInt(b.priority)-parseInt(a.priority)
                    })

                    this.filteredDone.sort((a,b) => {
                        return parseInt(b.priority)-parseInt(a.priority)
                    })
                } else if (this.selectedPriority === "chron") {
                    this.filteredTodo = this.todo
                    this.filteredInprogress = this.inprogress
                    this.filteredDone = this.done
                }
            },
            setDeadlineText(deadline) {
                if (!deadline) {
                    return 'No deadline'
                } else {
                    return deadline
                }
            },
            parseDate(date) {
                // Split timestamp into [ Y, M, D, h, m, s ]
                const t = date.split(/[- :]/)
                // Apply each element to the Date function
                const d = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]))
                const month = d.getMonth()
                const year = d.getFullYear()
                const day = d.getDate()
                return `${day}-${month}-${year}`
            },
            parseName(name) {
                if (!name) {
                    return 'Unassigned'
                } else {
                    return name
                }
            },
            beginTask(item, index, post_status_id) {
              const task = this.todo[index]
              this.todo.splice(index,1)
              this.inprogress.push(task)

              fetch('/endpoint/kanban/beginTask', {
                method: 'POST',
                headers: {
                  'content-type': 'application/json',
                  'accept': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                  post_id: item,
                  post_status_id,
                })
              })
              .then((response) => response.json())
              .then((data) => {
                console.log(data)
              })
            },
            completeTask(item,index, post_status_id) {
              const task = this.inprogress[index]
              this.inprogress.splice(index,1)
              this.done.push(task)

              fetch('/endpoint/kanban/completeTask', {
                method: 'POST',
                headers: {
                  'content-type': 'application/json',
                  'accept': 'application/json',
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                  post_id: item,
                  post_status_id
                })
              })
              .then((response) => response.json())
              .then((data) => {
                console.log(data)
              })
            },
            archieveTask(item, index) {
                const task = this.done[index]
                this.done.splice(index,1)

                fetch('/endpoint/kanban/archieveTask', {
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',
                        'accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        post_id: item
                    })
                    .then((response) => response.json())
                    .catch((e) => {
                        console.log(e)
                    })
                })
            }
          }
        }

    </script>
</x-app-layout>
