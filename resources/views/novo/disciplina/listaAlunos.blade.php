<table class="tableForum">
    @isset($lista_alunos)
        <tr>
            <th>Nome do aluno</th>
            <th>Número</th>
            <th>Email</th>
        </tr>
        @foreach ($lista_alunos as $user)
            <tr id="user_{{$user->id}}">
                <td>{{$user->nome}}</td>
                <td>{{$user->numero}}</td>
                <td>{{$user->email}}</td>
            </tr>
        @endforeach
    @endisset
</table>