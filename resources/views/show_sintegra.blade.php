@extends('layout.top')
   @section('content')     
     <div class="panel panel-default">
       <div class="panel-heading">
         <h3 class="panel-title">Lista de dados</h3>
       </div>
       <div class="panel-body">
         @foreach($sintegras as $sintegra)
               <div class="panel panel-info">
                    <div class="panel-body">
                         <h3>Consulta {!!$sintegra->id!!}</h3>
                         <ul>
                              @foreach(json_decode($sintegra->resultado_json) as $campo => $valor)
                                   <li>{!!$campo!!} : {!!$valor!!}</li>
                              @endforeach
                         </ul>
                         {!! csrf_field() !!}
                         <button type="button" id="{!!$sintegra->id!!}" class="btn_lista btn btn-default">Excluir</button>
                    </div>

               </div>
          @endforeach
       </div>
     </div>
     <script type="text/javascript" >
          $(".btn_lista").on("click",function(){
               if(confirm("Deseja realmente excluir essas informações?")){
                    $.post("/sintegra/excluir", {"id" : $(this).attr('id'), "_token":$("input[name='_token']").val()});
                    location.reload();
               }
          });
     </script>
   @endsection 
@extends('layout.bottom')
   
