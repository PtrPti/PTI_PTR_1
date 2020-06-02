<div class="discpContainer" id="users">
    <table class="tableGrupos" id="tableShowUsers">
        @isset($lista_users)
            <tr>
                <th>Nome</th>
                <th>Aluno</th>
            </tr>
            @foreach ($lista_users as $user)
                <tr id="user_{{$user->id}}">
                    <td>{{$user->nome}}</td>
                    <td>{{$user->numero}}</td>
                </tr>
            @endforeach
        @endisset
    </table>
</div>