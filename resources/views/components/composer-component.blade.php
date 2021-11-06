<div x-data="composerApp()">
    <div class="bg-white space-y-3 rounded-md border-1 border-gray-200 px-4 py-4 shadow-sm">
        <h2 for="post" class="font-bold block text-lg capitalize">Create post</h2>
        <div>
            <div id="postTitle" x-show="showControls" x-ref="postTitle" contenteditable="plaintext-only" x-ref="composer" name="post" id="post" class="w-full bg-gray-100 resize-none
                    rounded-t-lg focus-within:outline-none px-4 py-3" placeholder="Post title"></div>
            <div x-ref="postContent" @focus="showExtend()" contenteditable="plaintext-only" x-ref="composer" name="post" id="post" class="w-full bg-gray-100 resize-none
                    rounded-lg focus-within:outline-none px-4 py-3" placeholder="Write your post. Use markdown to format"></div>
            <span x-show="missingRequired" x-transition class="text-red-700 text-sm">Post title and content is required</span>
        </div>
        <div class="grid-cols-4 gap-4 grid" x-show="showControls" x-transition>
            <div>
                <h3 class="font-bold text-gray-500">
                    Category
                </h3>
                <select x-model="category" name="category"
                    class="w-full border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <h3 class="font-bold text-gray-500">Priority</h3>
                <select name="priority" x-model="priority"
                    class="w-full h-10 border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
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
                <input type="date" name="deadline" x-model="deadline"
                    class="w-full h-10 border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
            </div>
            <div x-show="category != 3" x-transition>
                <h3 class="font-bold text-gray-500">
                    Milestone
                </h3>
                <select name="milestone" x-model="milestone"
                    class="w-full h-10 border-gray-400 rounded-md focus:ring-opacity-50 focus:ring-indigo-300 mt-1">
                    <option disabled selected value="0">Select milestone</option>
                    @foreach ($milestones as $milestone)
                        <option value="{{ $milestone->milestone_id }}">{{ $milestone->milestone }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="buttons">
            <button @click="createPost"
                class="bg-blue-600 focus:bg-blue-700 focus:outline-none text-white font-bold rounded-lg px-3 py-2">Create
                Post</button>
            <label for="file-upload"
                class="bg-gray-200 inline-block cursor-pointer hover:bg-gray-300 focus:bg-gray-400 focus:outline-none text-gray-700 font-bold rounded-lg px-3 py-2">
                <i class="bi bi-paperclip"></i> Attach Files</label>
            <input x-model="attachments" x-ref="fileUpload" multiple @change="fileSelected" type="file" class="hidden" id="file-upload" />
        </div>
        <span class="text-blue-700 text-sm" x-show="submitting">Submitting, please wait.</span>
        <span class="text-red-700 text-sm" x-show="submitError">An error occured. Check your post before posting.</span>
        <div class="bg-indigo-100 rounded-md px-3 py-3" x-show="showFileNames" x-transition>
            <ul>
                <template x-for="(filename,index) in fileSelectedNames">
                    <li class="font-bold text-gray-700">
                        <i class="bi bi-file-earmark-fill"></i> <span x-text="filename"></span> <button class="bg-transparent px-3 text-sm" @click="removeFile(index)"><i class="bi bi-x-lg"></i> Remove</button>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</div>

<script>
    function composerApp() {
        return {
            createPost() {
                const endpoint = "/endpoint/new/post"
                const postContent = this.$refs.postContent.innerText
                const postTitle = this.$refs.postTitle.innerText
                const csrf = document.querySelector('meta[name="csrf-token"]').content;
                const form = new FormData()
                const files = this.$refs.fileUpload.files

                this.submitting = true
                this.submitError = false

                if (postContent.trim().length == 0) {
                    this.missingRequired = true
                    return
                }

                if (postTitle.trim().length == 0) {
                    this.missingRequired = true
                    return
                }

                form.append('post', postContent)
                form.append('category', this.category)
                form.append('priority', this.priority)
                form.append('deadline', this.deadline)
                form.append('milestone', this.milestone)
                form.append('title', postTitle)

                for (let index = 0; index < files.length; index++) {
                    const file = files[index]
                    const fileStatus = this.activeFiles[index]
                     if (fileStatus) {
                         form.append('attachments[]', file)
                     }
                }

                fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf
                    },
                    body: form
                })
                .then(response => response.json())
                .then((data) => {
                    if (data.status == 200) {
                        window.location.href = `/post/${data.post_id}`
                    }
                    this.submitting = false
                })
                .catch((e) => {
                    this.submitting = false
                    this.submitError = true
                })
            },
            showExtend() {
                this.$refs.postContent.classList.remove('rounded-lg')
                this.$refs.postContent.classList.add('rounded-b-lg')
                this.showControls = true
            },
            fileSelected() {
                const files = this.$refs.fileUpload.files
                this.fileSelectedNames = []
                this.activeFiles = []
                for (let index = 0; index < files.length; index++) {
                    const file = files[index]
                    this.fileSelectedNames.push(file.name)
                    this.activeFiles.push(true)
                }
                if (files.length > 0) {
                    this.showFileNames = true
                }
            },
            removeFile(index) {
                this.activeFiles[index] = false
                if (index > -1) {
                    this.fileSelectedNames.splice(index,1)
                }
                if (this.fileSelectedNames.length == 0) {
                    this.showFileNames = false
                }
            },
            fileSelectedNames: [],
            activeFiles: [],
            category: '2',
            priority: '3',
            deadline: '',
            milestone: '3',
            showControls: false,
            showFileNames: false,
            fileAttached: false,
            attachments: null,
            missingRequired: false,
            submitting: false,
            submitError: false,
        }
    }

</script>

<style>
    [contenteditable='plaintext-only']:empty:before {
        content: attr(placeholder);
        pointer-events: none;
        display: block;
        /* For Firefox */
        color: rgba(156, 163, 175, 1)
    }

    #postTitle {
        font-weight: 700;
        font-size: 1.25rem;
    }

</style>
