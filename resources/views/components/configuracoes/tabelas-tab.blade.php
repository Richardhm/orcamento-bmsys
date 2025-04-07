<div>
    <div id="aba_tabela" class="mt-4">
        <div id="container_alert_cadastrar" class="text-center"></div>

        <div class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] shadow rounded p-4">

                <div class="grid grid-cols-5 gap-4">
                    <!-- Administradora -->
                    <div>
                        <label for="administradora" class="block text-sm font-medium text-white">Administradora:</label>
                        <select name="administradora" id="administradora" class="tabela block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">--Escolher a Administradora--</option>
                            @foreach($administradoras as $aa)
                                <option value="{{$aa->id}}" {{$aa->id == old('administradora') ? 'selected' : ''}}>{{$aa->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('administradora'))
                            <p class="text-red-500 text-xs mt-1">{{$errors->first('administradora')}}</p>
                        @endif
                    </div>

                    <!-- Planos -->
                    <div>
                        <label for="planos" class="block text-sm font-medium text-white">Planos:</label>
                        <select name="planos" id="planos" class="tabela block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">--Escolher o Plano--</option>
                            @foreach($planos as $pp)
                                <option value="{{$pp->id}}" {{$pp->id == old('planos') ? 'selected' : ''}}>{{$pp->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('planos'))
                            <p class="text-red-500 text-xs mt-1">{{$errors->first('planos')}}</p>
                        @endif
                    </div>

                    <!-- Cidade -->
                    <div>
                        <label for="tabela_origem" class="block text-sm font-medium text-white">Cidade:</label>
                        <select name="tabela_origem" id="tabela_origem" class="tabela block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">--Escolher a Cidade--</option>
                            @foreach($tabela_origem as $cc)
                                <option value="{{$cc->id}}" {{$cc->id == old('tabela_origem') ? 'selected' : ''}}>{{$cc->nome}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('tabela_origem'))
                            <p class="text-red-500 text-xs mt-1">{{$errors->first('tabela_origem')}}</p>
                        @endif
                    </div>

                    <!-- Coparticipação -->
                    <div>
                        <label for="coparticipacao" class="block text-sm font-medium text-white">Coparticipação:</label>
                        <select name="coparticipacao" id="coparticipacao" class="tabela block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">--Escolher Coparticipacao--</option>
                            <option value="sim" {{old('coparticipacao') == "sim" ? 'selected' : ''}}>Com Coparticipação</option>
                            <option value="nao" {{old('coparticipacao') == "nao" ? 'selected' : ''}}>Coparticipação Parcial</option>
                        </select>
                        @if($errors->has('coparticipacao'))
                            <p class="text-red-500 text-xs mt-1">{{$errors->first('coparticipacao')}}</p>
                        @endif
                    </div>

                    <!-- Odonto -->
                    <div>
                        <label for="odonto" class="block text-sm font-medium text-white">Odonto:</label>
                        <select name="odonto" id="odonto" class="tabela block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">--Escolher Odonto--</option>
                            <option value="sim" {{old('odonto') == "sim" ? 'selected' : ''}}>Com Odonto</option>
                            <option value="nao" {{old('odonto') == "nao" ? 'selected' : ''}}>Sem Odonto</option>
                        </select>
                        @if($errors->has('odonto'))
                            <p class="text-red-500 text-xs mt-1">{{$errors->first('odonto')}}</p>
                        @endif
                    </div>
                </div>

                <!-- Valores Section -->
                <h4 class="text-center py-2 border-b border-gray-300 font-bold text-white">Valores</h4>
                <div class="grid grid-cols-3 gap-4 mt-4">
                    <!-- Apartamento -->
                    <div class="border-r border-gray-300 pr-4">
                        <h6 class="font-semibold underline text-white">Apartamento</h6>
                        @foreach($faixas as $k => $f)
                            <div class="flex items-center mt-2">
                                <input type="text" disabled class="border-none bg-transparent text-white" value="{{$f->nome}}">
                                <input type="hidden" name="faixa_etaria_id_apartamento[]" value="{{$f->id}}">
                                <input type="text" name="valor_apartamento[]" class="ml-2 border border-gray-300 rounded px-2 py-1 valor" placeholder="valor" value="{{ old('valor_apartamento')[$k] ?? '' }}" disabled>
                                @if($errors->any('valor_apartamento'.$k))
                                    <p class="text-red-500 text-xs mt-1">O valor da faixa etaria {{ $f->nome }} é obrigatório</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="border-r border-gray-300 pr-4">
                        <h6 class="font-semibold underline text-white">Enfermaria</h6>
                        @foreach($faixas as $k => $f)
                            <div class="flex items-center mt-2">
                                <input type="text" disabled class="border-none bg-transparent text-white" value="{{$f->nome}}">
                                <input type="hidden" name="faixa_etaria_id_enfermaria[]" value="{{$f->id}}">
                                <input type="text" name="valor_enfermaria[]" class="ml-2 border border-gray-300 rounded px-2 py-1 valor" placeholder="valor" value="{{ old('valor_apartamento')[$k] ?? '' }}" disabled>
                                @if($errors->any('valor_apartamento'.$k))
                                    <p class="text-red-500 text-xs mt-1">O valor da faixa etaria {{ $f->nome }} é obrigatório</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="col">
                        <h6 class="font-semibold underline text-white">Ambulatorial</h6>
                        @foreach($faixas as $k => $f)
                            <div class="flex items-center mt-2">
                                <input type="text" disabled class="border-none bg-transparent text-white" value="{{$f->nome}}">
                                <input type="hidden" name="faixa_etaria_id_ambulatorial[]" value="{{$f->id}}">
                                <input type="text" name="valor_ambulatorial[]" class="ml-2 border border-gray-300 rounded px-2 py-1 valor" placeholder="valor" value="{{ old('valor_apartamento')[$k] ?? '' }}" disabled>
                                @if($errors->any('valor_apartamento'.$k))
                                    <p class="text-red-500 text-xs mt-1">O valor da faixa etaria {{ $f->nome }} é obrigatório</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>


                <div id="container_btn_cadastrar" class="w-full">

                </div>




        </div>
    </div>
</div>
