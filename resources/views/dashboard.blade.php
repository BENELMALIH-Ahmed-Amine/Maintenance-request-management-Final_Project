<x-app-layout>
    <div class="py-12">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-12">
                <section class="w-[200px] py-3 bg-white flex flex-col gap-3 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <h3 class="pb-[6px] text-[18px] text-center border-b border-black hover:bg-gray-300">Choose a category</h3>
                    @foreach ($categorys as $category)
                        <div class="py-3 px-6 text-center hover:bg-gray-200">{{ $category->name }}</div>
                    @endforeach
                </section>
                
                <section class="w-full p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    @foreach ($posts as $post)
                        <div>{{ $post }}</div>
                    @endforeach
                </section>
            </div>
         </div>
    </div>
</x-app-layout>
