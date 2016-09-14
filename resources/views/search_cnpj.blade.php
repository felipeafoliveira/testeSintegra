@extends('layout.top')
   @section('content')
     <div class="panel panel-default">
       <div class="panel-heading">
         <h3 class="panel-title">Consulta Sintegra</h3>
       </div>
       <div class="panel-body">
          <form method="post" action="/api">
               {!! csrf_field() !!}
               <div class="input-group">
                    <input type="text" placeholder="CNPJ" class="form-control" name="num_cnpj" />
                    <div class="btn-group">
                         <button type="submit" class="btn btn-default" value="Enviar">Enviar</button>
                    </div>
               </div>
          </form>
     </div>
     </div>
   @endsection 
@extends('layout.bottom')
   