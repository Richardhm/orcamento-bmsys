<x-app-layout>
    <div class="container mx-auto mt-10 px-4">
        <h1 class="text-2xl font-bold mb-8 text-white text-center drop-shadow-lg bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] rounded w-[50%] mx-auto">
            Escolha o Layout
        </h1>

        <!-- Feedback de Sucesso -->
        @if(session('success'))
            <div class="p-4 mb-6 text-green-100 bg-green-600 border border-green-300 rounded-lg text-center shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <form action="" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($layouts as $layout)
                    <label class="relative group flex flex-col items-center border p-1 rounded bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px]">
                        
                        <!-- Input Radio destacado (agora fica acima da imagem) -->
                        <input type="radio" id="layout_{{ $layout->id }}"
                            name="layout_id"
                            value="{{ $layout->id }}"
                            {{ $layout->id == $user->layout_id ? 'checked' : '' }}
                            class="w-7 h-7 mb-2 cursor-pointer appearance-none border-4 border-white rounded-full transition duration-300 checked:border-purple-500 checked:ring-4 checked:ring-purple-400 shadow-lg bg-gray-200 hover:scale-110">
                        
                        <!-- Imagem -->
                        <div class="relative w-full bg-red">
                            <img src="{{ asset($layout->imagem) }}"
                                alt="{{ $layout->nome }}"
                                class="w-[70%] h-48 mx-auto object-cover rounded-lg transition-all duration-300 group-hover:opacity-75">
                        </div>

                        <!-- Nome do Layout -->
                        <p class="mt-4 text-center font-semibold text-white drop-shadow-sm">{{ $layout->nome }}</p>
                    </label>
                @endforeach
            </div>

            <!-- Botão de salvar -->
            <div class="flex justify-center mt-10">
                <button type="submit"
                        class="px-10 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-full transition duration-300 shadow-lg">
                    Salvar Seleção
                </button>
            </div>
        </form>
    </div>

    <style>
        /* Ajuste para input radio ficar destacado acima da imagem */
        input[type="radio"] {
            width: 30px;
            height: 30px;
            background-color: white;
            border-radius: 50%;
            border: 4px solid white;
            transition: all 0.3s ease-in-out;
        }

        input[type="radio"]:checked {
            border-color: #7B3AED;
            background-color: #7B3AED;
            box-shadow: 0 0 10px rgba(123, 58, 237, 0.6);
        }

        input[type="radio"]:hover {
            transform: scale(1.2);
        }
    </style>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }
               });
            
            
            
            $("input[name='layout_id']").on('change',function(){
               let valor = $(this).val();
               let load = $(".ajax_load");
               $.ajax({
                  url:"{{route('layouts.select')}}",
                  method:"POST",
                  data: {
                    valor
                  },
                  beforeSend: function () {
                    load.fadeIn(100).css("display", "flex");
                  },
                  success:function(res) {
                      load.fadeOut(100).css("display", "none");
                      if(res == "sucesso") {
                          toastr.success("Layout trocado com sucesso.", "Sucesso",{
                            toastClass: "toast-custom-width"
                        });
                      } else {
                          toastr.error("Erro ao mudar de Layout. Verifique e tente novamente.", "Error",{
                            toastClass: "toast-custom-width"
                        });
                      }
                  }
               });
            });
        });
    </script>
</x-app-layout>
