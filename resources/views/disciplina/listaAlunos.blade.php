<table class="tableForum">
    @isset($lista_alunos)
        <tr>
            <th>{{ __('change.nomeAluno') }}</th>
            <th>{{ __('change.numeroAluno') }}</th>
            <th>{{ __('change.emailAluno') }}</th>
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