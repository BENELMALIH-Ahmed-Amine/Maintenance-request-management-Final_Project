<x-app-layout>
    <div class="py-12">
        <div class="max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <form action="/newPosts" method="POST" id="test">
                @csrf

                <div class="flex gap-8">
                    <section
                        class="w-[300px] h-fit py-3 bg-white flex flex-col gap-3 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="pb-[6px] text-[18px] text-center border-b border-black">Choose a
                            category</h3>
                        <a class="cursor-pointer py-3 px-6 text-center hover:bg-gray-200"
                            href="{{ route('newPosts') }}">All category</a>
                        @foreach ($categorys as $category)
                            <div class="cursor-pointer py-3 px-6 text-center hover:bg-gray-200 categoryDiv">
                                {{ $category->name }}</div>
                        @endforeach

                        {{-- category --}}
                        <select id="hiddenCategory" name="category_id" class="hidden">
                            @foreach ($categorys as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="pt-[10px] border-t border-black flex justify-center gap-5">
                            <button type="submit" class="px-3 py-0.5 bg-slate-300 text-[18px] rounded-3xl hover:bg-slate-400">Filter</button>
                            <button id="resetCategory" type="button" class="px-3 py-0.5 bg-slate-300 text-[18px] rounded-3xl hover:bg-slate-400">Reset</button>
                        </div>
                    </section>

                    <section
                        class="w-full p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-wrap justify-center gap-x-5 gap-y-8">
                        @foreach ($clientPosts as $clientPost)
                            <article class="w-[360px] h-fit p-3 bg-slate-200 rounded-2xl">
                                <div class="mb-5 flex items-center justify-between">
                                    <h1 class="h-[67px] overflow-scroll text-[22px] underline">{{ $clientPost->title }}
                                    </h1>
                                    <span
                                        class="w-[100px] h-fit pt-0.5 pb-1 px-3 bg-gray-400 rounded-xl text-center text-black font-semibold">{{ $clientPost->status->name }}</span>
                                </div>
                                <p class="h-[60px] overflow-scroll text-[18px]">{{ $clientPost->description }}</p>
                                <div class="w-full h-[300px] mt-3 bg-slate-300 rounded-[20px]">
                                    <img class="w-full h-full rounded-[20px]"
                                        src="{{ asset('storage/' . $clientPost->image) }}" alt="">
                                </div>
                            </article>
                        @endforeach
                    </section>

                    <section
                        class="w-[300px] h-fit py-3 bg-white flex flex-col gap-3 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <h3 class="pb-[6px] text-[18px] text-center border-b border-black">Choose a
                            status</h3>
                        <a class="cursor-pointer py-3 px-6 text-center hover:bg-gray-200"
                            href="{{ route('newPosts') }}">All statuses</a>
                        @foreach ($statuses as $status)
                            <div class="cursor-pointer py-3 px-6 text-center hover:bg-gray-200 statusDiv">
                                {{ $status->name }}</div>
                        @endforeach

                        {{-- status --}}
                        <select id="hiddenStatus" name="status_id" class="hidden">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        <div class="pt-[10px] border-t border-black flex justify-center gap-5">
                            <button type="submit" class="px-3 py-0.5 bg-slate-300 text-[18px] rounded-3xl hover:bg-slate-400">Filter</button>
                            <button id="resetStatus" type="button" class="px-3 py-0.5 bg-slate-300 text-[18px] rounded-3xl hover:bg-slate-400">Reset</button>
                        </div>
                    </section>
                </div>
            </form>
        </div>
    </div>

    <script>
        hiddenCategory.value = 0
        
        let categoryDiv = document.querySelectorAll('.categoryDiv')
        Array.from(categoryDiv).forEach(divOption => {
            divOption.onclick = () => {
                hiddenCategory.value = Array.from(categoryDiv).indexOf(divOption) + 1
            };
        });
        
        resetCategory.onclick = () => {
            hiddenCategory.value = 0
        }


        hiddenStatus.value = 0
        
        let statusDiv = document.querySelectorAll('.statusDiv')
        Array.from(statusDiv).forEach(divOption => {
            divOption.onclick = () => {
                hiddenStatus.value = Array.from(statusDiv).indexOf(divOption) + 1
            };
        });

        resetStatus.onclick = () => {
            hiddenStatus.value = 0
        }
    </script>
</x-app-layout>
