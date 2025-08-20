<x-app-layout>
    <div class="py-12">
        <div class="max-w-[1800px] mx-auto sm:px-6 lg:px-8 relative">
            {{-- Filter --}}
            <form action="/filterPosts" method="POST" id="test" class="relative">
                @csrf

                {{-- category --}}
                <section
                    class="w-[220px] h-fit py-3 bg-white flex flex-col gap-[1px] dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <h3 class="pb-[6px] text-[18px] text-center border-b border-black">Choose a
                        category</h3>
                    <a class="cursor-pointer py-3 px-6 flex gap-3 items-center hover:bg-gray-200"
                        href="{{ route('newPosts') }}" id="allCategory">
                        <input type="radio" class="w-[15px] h-[15px] " id="">
                        <span>All categories</span>
                    </a>
                    @foreach ($categorys as $category)
                        <div class="cursor-pointer py-3 px-6 flex gap-3 items-center hover:bg-gray-200 categoryDiv">
                            <input type="radio" class="w-[15px] h-[15px] categoryBox" id="">
                            <label for="">{{ $category->name }}</label>
                        </div>
                    @endforeach

                    <select id="hiddenCategory" name="category_id" class="hidden">
                        @foreach ($categorys as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="pt-[10px] border-t border-black flex justify-center gap-5">
                        <button type="submit"
                            class="px-3 py-0.5 bg-slate-300 text-[18px] rounded-3xl hover:bg-slate-400">Filter</button>
                    </div>
                </section>

                {{-- status --}}
                <section
                    class="w-[220px] h-fit py-3 bg-white flex flex-col gap-[1px] dark:bg-gray-800 shadow-sm sm:rounded-lg absolute top-0 right-0">
                    <h3 class="pb-[6px] text-[18px] text-center border-b border-black">Choose a
                        status</h3>
                    <a class="cursor-pointer py-3 px-6 flex gap-3 items-center hover:bg-gray-200"
                        href="{{ route('newPosts') }}" id="allStatus">
                        <input type="radio" class="w-[15px] h-[15px] ">
                        <span>All statuses</span>
                    </a>
                    @foreach ($statuses as $status)
                        <div class="cursor-pointer py-3 px-6 flex gap-3 items-center hover:bg-gray-200 statusDiv">
                            <input type="radio" class="w-[15px] h-[15px] statusBox" id="">
                            <label for="">{{ $status->name }}</label>
                        </div>
                    @endforeach

                    <select id="hiddenStatus" name="status_id" class="hidden">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                    <div class="pt-[10px] border-t border-black flex justify-center gap-5">
                        <button type="submit"
                            class="px-3 py-0.5 bg-slate-300 text-[18px] rounded-3xl hover:bg-slate-400">Filter</button>
                    </div>
                </section>
            </form>

            {{-- Posts --}}
            <section
                class="w-[1200px] h-[740px] p-6 bg-white dark:bg-gray-800 overflow-scroll shadow-sm sm:rounded-lg flex flex-wrap justify-center gap-x-5 gap-y-8 absolute top-0 right-[300px]">
                @foreach ($posts as $post)
                    <article class="w-[360px] h-fit p-3 bg-slate-200 rounded-2xl">
                        <div class="mb-5 flex items-center justify-between">
                            <h1 class="h-[67px] overflow-scroll text-[22px] underline">{{ $post->title }}
                            </h1>
                            <span
                                class="w-[100px] h-fit pt-0.5 pb-1 px-3 bg-gray-400 rounded-xl text-center text-black font-semibold">{{ $post->status->name }}</span>
                        </div>
                        <p class="h-[60px] overflow-scroll text-[18px]">{{ $post->description }}</p>
                        <div class="w-full h-[300px] mt-3 bg-slate-300 rounded-[20px]">
                            <img class="w-full h-full rounded-[20px]" src="{{ asset('storage/' . $post->image) }}"
                                alt="">
                        </div>

                        {{-- Assign Technitions --}}
                        <form action="/assign/{{ $post->id }}" method="POST" class="mt-3">
                            @csrf
                            
                            <select name="user_id" class="w-full p-2 border rounded assignTech">
                                <option value="">{{ $post->category->name }}</option>
                                @foreach ($techs->where('category_id', $post->category_id) as $tech)
                                    <option value="{{ $tech->id }}"
                                        {{ $post->assignment?->user_id == $tech->id ? 'selected' : '' }}
                                        class="tech">
                                        {{ $tech->name }}&nbsp;//&nbsp;<span>{{ $tech->category->name }}</span>
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </article>
                @endforeach
            </section>
        </div>
    </div>

    <script>
        // Category
        hiddenCategory.value = 0

        let allCategoryBox = allCategory.firstChild.nextSibling
        allCategory.onclick = () => {
            allCategoryBox.checked = true
        }

        let categoryDiv = document.querySelectorAll('.categoryDiv')
        let categoryBoxes = document.querySelectorAll('.categoryBox')

        Array.from(categoryDiv).forEach(divOption => {
            divOption.onclick = () => {
                categoryBoxes.forEach(box => {
                    box.checked = false
                });

                let categoryChek = divOption.firstChild.nextSibling
                categoryChek.checked = true
                hiddenCategory.value = Array.from(categoryDiv).indexOf(divOption) + 1
            };
        });


        // Status
        hiddenStatus.value = 0

        let allStatusBox = allStatus.firstChild.nextSibling
        allStatus.onclick = () => {
            allStatusBox.checked = true
        }

        let statusDiv = document.querySelectorAll('.statusDiv')
        let statusBoxes = document.querySelectorAll('.statusBox')

        Array.from(statusDiv).forEach(divOption => {
            divOption.onclick = () => {
                statusBoxes.forEach(box => {
                    box.checked = false
                });

                let statusChek = divOption.firstChild.nextSibling
                statusChek.checked = true
                hiddenStatus.value = Array.from(statusDiv).indexOf(divOption) + 1
            };
        });


        // Assign
        let assignTech = document.querySelectorAll('.assignTech')

        assignTech.forEach(s => {
            s.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    </script>
</x-app-layout>
