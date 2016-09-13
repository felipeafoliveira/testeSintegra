<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    </head>
    <body>

        
        <form method="POST" action="/auth/login">
            {!! csrf_field() !!}
        
            <div>
                Usuário
                <input type="user" name="user" value="{{ old('user') }}">
            </div>
        
            <div>
                Senha
                <input type="password" name="password" id="password">
            </div>
        
            <div>
                <input type="checkbox" name="remember"> Lembrar Senha
            </div>
        
            <div>
                <button type="submit">Login</button>
            </div>
</form>
    </body>
</html>