<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 text-center dark:text-gray-200 leading-tight">
            @role('Client')
                Ajoutez votre problème
            @else
                Mes tâches
            @endrole
        </h2>
    </x-slot>

    {{-- Todo: separe client / tech --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col gap-[50px]">
                <section class="p-6 text-gray-900 dark:text-gray-100 flex justify-center">
                    @role('Client')
                        <form action="/post/store" method="POST" enctype="multipart/form-data"
                            class="h-fit px-2.5 py-3 bg-gray-300 rounded-2xl flex flex-col gap-3">
                            @csrf

                            {{-- title --}}
                            <input type="text" name="title" id="" class="focus:ring-0 rounded-lg"
                                placeholder="Title">

                            {{-- image --}}
                            <input type="file" accept="image/*" name="image" id="" class="focus:ring-0">

                            {{-- description --}}
                            <textarea type="text" name="description" id="" class="focus:ring-0" placeholder="description"></textarea>

                            {{-- status(Client) --}}
                            <select name="status_id" class="focus:ring-0">
                                <option value="" selected>Urgent</option>
                                @for ($i = 0; $i < 3; $i++)
                                    <option value="{{ $statuses[$i]->id }}">{{ $statuses[$i]->name }}</option>
                                @endfor
                            </select>

                            {{-- category --}}
                            <select name="category_id" class="focus:ring-0">
                                <option value="" selected>Catégorie de votre problème</option>
                                @foreach ($categorys as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            {{-- user_id --}}
                            <input name="user_id" id="" class="hidden" value="{{ Auth::user()->id }}">

                            <button type="submit"
                                class="mt-2 py-1 px-3 bg-white rounded-lg hover:bg-gray-100">Publier</button>
                        </form>
                    @endrole

                    <div
                        class="px-6 pb-6 text-gray-900 dark:text-gray-100 flex flex-wrap justify-center gap-x-5 gap-y-8">
                        @foreach ($posts as $post)
                            <article class="h-[530px] bg-slate-200 relative">
                                <form action="/post/update/{{ $post->id }}" method="POST"3
                                    class="w-[360px] p-3 pb-0 bg-slate-200 rounded-2xl edit" id="">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-5 flex items-center justify-between">
                                        <textarea name="title" class="w-[250px] p-0 bg-slate-200  focus:ring-0 text-[22px] underline">{{ $post->title }}</textarea>
                                        <span
                                            class="h-fit pt-0.5 pb-[5px] px-3 bg-gray-400 rounded-2xl text-white font-semibold">{{ $post->status->name }}</span>
                                    </div>

                                    <textarea name="description"
                                        class="w-full h-fit py-0 px-[10px] bg-slate-200 focus:ring-0 text-[18px]">{{ $post->description }}</textarea>
                                    <div class="h-[300px]">
                                        <img class="w-full h-full rounded-[10px]"
                                            src="{{ asset('storage/' . $post->image) }}" alt="">
                                    </div>

                                    {{-- Edit --}}
                                    @role('Client')
                                        <button id="" type="button"
                                            class="editBtn px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-red active:bg-green-600 transition duration-150 ease-in-out absolute bottom-3 left-[90px]">
                                            Edit
                                        </button>
                                    @endrole
                                </form>

                                {{-- Delete --}}
                                @role('Client')
                                    <form action="/post/destroy/{{ $post->id }}" method="POST"
                                        class="absolute bottom-3 right-[90px]">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out">
                                            DELETE
                                        </button>
                                    </form>
                                @endrole
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="p-6 bg-gray-700 dark:bg-gray-200 dark:text-gray-900 flex flex-wrap gap-10">
                    <h3 class="w-full bg-gray-300 text-[28px] text-center">Problèmes résolus</h3>
                    <div class="flex flex-wrap justify-center gap-x-5 gap-y-8 text-gray-100">
                        @foreach ($posts as $post)
                            <article class="w-[360px] p-3 bg-slate-600 rounded-2xl">
                                <div class="mb-5 flex items-center justify-between">
                                    <h1 class="h-[67px] overflow-scroll text-[22px] underline">{{ $post->title }}
                                    </h1>
                                    <span
                                        class="h-fit pt-0.5 pb-1 px-3 bg-gray-400 rounded-2xl text-black font-semibold">{{ $post->status->name }}</span>
                                </div>
                                <p class="h-[50px] overflow-scroll text-[18px]">{{ $post->description }}</p>
                                <div class="mt-3 h-[300px]"><img class="w-full h-full rounded-[20px]"
                                        src="{{ asset('storage/' . $post->image) }}" alt=""></div>
                            </article>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>

    <script>
        let posts = document.querySelectorAll('.edit');

        posts.forEach(f => {
            let title = f.querySelector('[name="title"]')
            let description = f.querySelector('[name="description"]')
            let editBtn = f.querySelector('.editBtn')

            title.readOnly = true
            description.readOnly = true
            title.classList.add('resize-none')
            description.classList.add('resize-none')
            title.classList.add('border-none')
            description.classList.add('border-none')

            editBtn.addEventListener('click', (event) => {
                event.preventDefault();

                if (editBtn.textContent == 'Edit') {
                    editBtn.textContent = 'Save'
                    editBtn.type = 'submit'
                    title.readOnly = false
                    description.readOnly = false
                    title.classList.remove('resize-none')
                    title.classList.remove('border-none')
                    description.classList.remove('resize-none')
                    description.classList.remove('border-none')
                } else {
                    editBtn.textContent = 'Edit'
                    editBtn.type = 'button';
                    title.readOnly = true
                    description.readOnly = true
                    title.classList.add('resize-none')
                    title.classList.add('border-none')
                    description.classList.add('resize-none')
                    description.classList.add('border-none')
                }
            });
        });
    </script>
</x-app-layout>
