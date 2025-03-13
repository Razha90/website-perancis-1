 <div class="relative w-[360px] h-[250px] rounded-xl overflow-hidden shadow-xl group cursor-pointer animate-fade"
     @click="window.location.href = '{{ route('classroom-learn', ['id' => $classroom->id]) }}'">
     <div class="absolute w-full h-full" x-data="{ loaded: false }">

         <div x-show="!loaded" class="w-full h-full flex items-center justify-center bg-gray-200">
             <span class="animate-spin h-10 w-10 border-4 border-gray-400 border-t-transparent rounded-full"></span>
         </div>
         <img src="{{ asset($classroom->image) }}" alt="{{ $classroom->title }}"
             class="w-full h-full object-cover transition-opacity duration-300 ease-in-out"
             x-bind:class="loaded ? 'opacity-100' : 'opacity-0'" @load="loaded = true" loading="lazy">
     </div>
     <div
         class="absolute w-full p-4 transition-all duration-300 h-full 
        translate-y-[70%] group-hover:translate-y-[25%] 
        bg-gradient-to-t from-black/80 to-black/30 group-hover:from-black/60 group-hover:bg-black/50">
         <p class="text-white font-semibold">{{ $classroom->title }}</p>
     </div>
 </div>
