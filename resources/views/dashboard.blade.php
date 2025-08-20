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
                            <article class="h-[500px] bg-slate-200 relative">
                                <form action="/post/update/{{ $post->id }}" method="POST"3
                                    class="w-[360px] p-3 pb-0 bg-slate-200 rounded-2xl edit" id="">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-5 flex items-center justify-between">
                                        <textarea readonly name="title"
                                            class="w-[250px] p-0 bg-slate-200 overflow-hidden border-none resize-none focus:ring-0 text-[22px] underline">{{ $post->title }}</textarea>

                                        {{-- user's infos --}}
                                        <div class="relative">
                                            @role('Client')
                                                @php
                                                    $statusColor = 'gray-400';
                                                    if ($post->status->name == 'En cours - يتِم') {
                                                        $statusColor = 'orange-500';
                                                    } elseif ($post->status->name == 'Terminé - تَم') {
                                                        $statusColor = 'green-500';
                                                    }
                                                @endphp
                                                <section
                                                    class="w-[60px] h-[60px] rounded-xl border-[1.8px]border-black relative">
                                                    <img class="w-full h-full rounded-xl border-[2px] border-black"
                                                        src="{{ asset('storage/' . $post->assignment?->user?->profil) }}"
                                                        alt="waiting">
                                                    <x-bi-info-circle
                                                        class="w-[20px] h-[20px] bg-{{ $statusColor }} text-white rounded-full absolute top-[7px] -right-[7px] info" />
                                                </section>

                                                <section class="w-[250px] p-3 bg-gray-300 break-all z-[1] hidden absolute">
                                                    <h3>
                                                        Name:&nbsp;{{ $post->assignment?->user?->name ?? 'Not assigned yet' }}
                                                    </h3>
                                                    <p>
                                                        Email:&nbsp;{{ $post->assignment?->user?->email ?? 'Not assigned yet' }}
                                                    </p>
                                                    <h4>
                                                        Address:&nbsp;{{ $post->assignment?->user?->address ?? 'Not assigned yet' }}
                                                    </h4>
                                                </section>
                                            @endrole
                                            @role('Technician')
                                                @php
                                                    $statusColor = 'gray-400';
                                                    if ($post->status->name == 'Urgent - عاجل') {
                                                        $statusColor = 'red-500';
                                                    } elseif ($post->status->name == '3/4 jours - أيام') {
                                                        $statusColor = 'blue-500';
                                                    } elseif ($post->status->name == 'Semaine - أسبوع') {
                                                        $statusColor = 'black';
                                                    } elseif ($post->status->name == 'En cours - يتِم') {
                                                        $statusColor = 'orange-500';
                                                    } elseif ($post->status->name == 'Terminé - تَم') {
                                                        $statusColor = 'green-500';
                                                    }
                                                @endphp
                                                <section
                                                    class="w-[60px] h-[60px] rounded-xl border-[1.8px]border-black relative">
                                                    <img class="w-full h-full rounded-xl border-[2px] border-black"
                                                        src="{{ asset('storage/' . $post->user->profil) }}" alt="">
                                                    <x-bi-info-circle
                                                        class="w-[20px] h-[20px] bg-{{ $statusColor }} text-white rounded-full absolute top-[7px] -right-[7px] info" />
                                                </section>

                                                <section class="w-[250px] p-3 bg-gray-300 break-all z-[1] hidden absolute">
                                                    <h3>Name:&nbsp;{{ $post->user->name }}</h3>
                                                    <p>Email:&nbsp;{{ $post->user->email }}</p>
                                                    <h4>Address:&nbsp;{{ $post->user->address }}</h4>
                                                </section>
                                            @endrole
                                        </div>
                                    </div>

                                    <textarea readonly name="description"
                                        class="w-full h-fit py-0 px-[10px] bg-slate-200 border-none resize-none focus:ring-0 text-[18px]">{{ $post->description }}</textarea>
                                    <div class="h-[300px] border border-black rounded-[10px]">
                                        <img class="w-full h-full rounded-[10px]"
                                            src="{{ asset('storage/' . $post->image) }}" alt="">
                                    </div>

                                    @role('Client')
                                        {{-- Edit --}}
                                        <button id="" type="button"
                                            class="editBtn px-4 py-2 font-medium text-white bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:shadow-outline-red active:bg-green-600 transition duration-150 ease-in-out absolute bottom-3 left-[90px]">
                                            Edit
                                        </button>
                                    @endrole
                                </form>

                                @role('Client')
                                    {{-- Delete --}}
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

                                @role('Technician')
                                    <div class="flex justify-around items-center">
                                        {{-- status(Technician) --}}
                                        <form action="/post/accept/{{ $post->id }}" method="POST"
                                            class="w-[70%] mt-2">
                                            @csrf
                                            @method('PUT')

                                            {{-- Doing - Done --}}
                                            <select name="status_id" class="w-full p-2 border rounded taskStatus">
                                                <option value="">Etat de la tâche</option>
                                                <option value="{{ $statuses[3]->id }}"
                                                    {{ $post->status_id == $statuses[3]->id ? 'selected' : '' }}>
                                                    {{ $statuses[3]->name }}</option>
                                                <option value="{{ $statuses[4]->id }}"
                                                    {{ $post->status_id == $statuses[4]->id ? 'selected' : '' }}>
                                                    {{ $statuses[4]->name }}</option>
                                            </select>
                                            <button type="submit" id="tst"></button>
                                        </form>

                                        {{-- Chat with the Client --}}
                                        <a href="{{ url('/chatify/' . $post->user->id) }}" class="relative">
                                            <x-bi-chat-fill class="w-[25px] h-[25px] hover:text-gray-500" />
                                            @if ($unreadCounts > 0)
                                                <span
                                                    class="px-[6px] bg-red-500 rounded-full text-white text-[13px] absolute top-0 left-5">
                                                    {{ $unreadCounts }}
                                                </span>
                                            @endif
                                        </a>
                                    </div>
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
        // Client's Info:
        let info = document.querySelectorAll('.info');
        info.forEach(i => {
            let clientInfo = i.parentElement.nextElementSibling

            i.addEventListener('mouseover', () => {
                clientInfo.classList.remove('hidden')

            })

            clientInfo.addEventListener('click', () => {
                clientInfo.classList.add('hidden')

            })
        });


        // accept
        let taskStatus = document.querySelectorAll('.taskStatus')

        console.log(taskStatus);
        taskStatus.forEach(s => {
            s.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });


        // Post allow edit:
        // let posts = document.querySelectorAll('.edit');

        // posts.forEach(f => {
        //     let title = f.querySelector('[name="title"]')
        //     let description = f.querySelector('[name="description"]')
        //     let editBtn = f.querySelector('.editBtn')

        //     title.readOnly = true
        //     description.readOnly = true
        //     title.classList.add('resize-none')
        //     description.classList.add('resize-none')
        //     title.classList.add('border-none')
        //     description.classList.add('border-none')

        //     editBtn.addEventListener('click', (event) => {
        //         event.preventDefault();

        //         if (editBtn.textContent == 'Edit') {
        //             editBtn.textContent = 'Save'
        //             editBtn.type = 'submit'
        //             title.readOnly = false
        //             description.readOnly = false
        //             title.classList.remove('resize-none')
        //             title.classList.remove('border-none')
        //             description.classList.remove('resize-none')
        //             description.classList.remove('border-none')
        //         } else {
        //             editBtn.textContent = 'Edit'
        //             editBtn.type = 'button';
        //             title.readOnly = true
        //             description.readOnly = true
        //             title.classList.add('resize-none')
        //             title.classList.add('border-none')
        //             description.classList.add('resize-none')
        //             description.classList.add('border-none')
        //         }
        //     });
        // });
    </script>
</x-app-layout>
