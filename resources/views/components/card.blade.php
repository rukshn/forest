<div class="border-1 border-gray-200 border shadow-sm rounded-md py-2 px-4 grid grid-cols-12 gap-3">
    <!-- He who is contented is rich. - Laozi -->
    <div class="font-bold col-span-4">
        <a class="hover: text-blue-700" href="/post/{{ $pid }}">{{ $title }}</a>
    </div>
    <div class="col-span-12 lg:col-span-1"><span class="rounded-lg text-white text-sm font-bold px-2 py-1" style="background-color: #{{$ccolor}}">{{ $category }}<span></div>
    @if($status != '')
    <div class="col-span-3 lg:col-span-2"><span class="rounded-lg text-white text-sm font-bold px-2 py-1" style="background-color: #{{$scolor}}">{{$status}}</span></div>
    @endif
    <div class="col-span-3 lg:col-span-2 text-gray-500 text-sm">{{ $author }}</div>
    <div class="col-span-2 lg:col-span-2 hidden lg:block text-gray-500 text-sm font-light">{{ $date }}</div>
    <div class="col-span-2 lg:col-span-1 text-gray-500 text-sm"><i class="bi bi-chat mr-2"></i> {{ $comments}}</div>
</div>