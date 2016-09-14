@extends('layout.top')
   @section('content')
       <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Login</h3>
            </div>
            <div class="panel-body">
             <form method="POST" action="/auth/login">
                 {!! csrf_field() !!}
             
                 <div class="input-group">
                     Usuário
                     <input type="user" class="form-control" name="user" value="{{ old('user') }}">
                 </div>
             
                 <div class="input-group">
                     Senha
                     <input type="password" class="form-control" name="password" id="password">
                 </div>
             
                 <div>
                     <button type="submit" class="btn btn-default">Login</button>
                 </div>
             </form>
            </div>
       </div>
   @endsection 
@extends('layout.bottom')
   