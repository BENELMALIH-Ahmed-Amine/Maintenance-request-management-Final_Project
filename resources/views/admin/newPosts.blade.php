<x-app-layout>
    <div class="py-12">
        <div class="max-w-[1800px] mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-8">
                <section
                    class="w-[300px] h-fit py-3 bg-white flex flex-col gap-3 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="pb-[6px] text-[18px] text-center border-b border-black hover:bg-gray-300">Choose a
                        category</h3>
                    @foreach ($categorys as $category)
                        <div class="py-3 px-6 text-center hover:bg-gray-200 categoryDiv">{{ $category->name }}</div>
                    @endforeach

                    {{-- category --}}
                    <select id="hiddenCategory" name="category_id" class="">
                        <option value="" selected>Catégorie de votre problème</option>
                        @foreach ($categorys as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </section>

                <section
                    class="w-full p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-wrap justify-center gap-x-5 gap-y-8">
                    @foreach ($clientPosts as $clientPost)
                        <article class="w-[360px] h-fit p-3 bg-slate-200 rounded-2xl">
                            <div class="mb-5 flex items-center justify-between">
                                <h1 class="h-[67px] overflow-scroll text-[22px] underline">{{ $clientPost->title }}</h1>
                                <span
                                    class="h-fit pt-0.5 pb-1 px-3 bg-gray-400 rounded-2xl text-black font-semibold">{{ $clientPost->status->name }}</span>
                            </div>
                            <p class="h-[60px] overflow-scroll text-[18px]">{{ $clientPost->description }}</p>
                            <div class="w-full h-[300px] mt-3 bg-slate-300 rounded-[20px]">
                                <img class="w-full h-full rounded-[20px]"
                                    src="{{ asset('storage/' . $clientPost->image) }}" alt="">
                            </div>

                            {{-- Delete --}}
                            <form action="/admin/post/destroy/{{ $clientPost->id }}" method="POST"
                                class="w-full flex justify-center mt-3">
                                @csrf
                                @method('DELETE')

                                <button
                                    class="px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">
                                    DELETE
                                </button>
                            </form>
                        </article>
                    @endforeach
                </section>

                <section
                    class="w-[300px] h-fit py-3 bg-white flex flex-col gap-3 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="pb-[6px] text-[18px] text-center border-b border-black hover:bg-gray-300">Choose a
                        status</h3>
                    {{-- <div id="statuses"> --}}
                    @foreach ($statuses as $status)
                        <div class="cursor-pointer py-3 px-6 text-center hover:bg-gray-200 statusDiv">
                            {{ $status->name }}</div>
                    @endforeach
                    {{-- </div> --}}

                    {{-- status --}}
                    <select id="hiddenStatus" name="status_id" class="hiddden">
                        <option value="" selected>Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endforeach
                    </select>
                </section>
            </div>
        </div>
    </div>

    <script>
        let categoryDiv = document.querySelectorAll('.categoryDiv')

        Array.from(categoryDiv).forEach(divOption => {
            divOption.onclick = () => {
                hiddenCategory.value = Array.from(categoryDiv).indexOf(divOption) + 1
            };
        });


        let statusDiv = document.querySelectorAll('.statusDiv')

        Array.from(statusDiv).forEach(divOption => {
            divOption.onclick = () => {
                hiddenStatus.value = Array.from(statusDiv).indexOf(divOption) + 1
            };
        });
    </script>
</x-app-layout>
