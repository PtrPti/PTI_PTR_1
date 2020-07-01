<table class="adminTable">
    <thead>
        <tr>
            <th></th>
            <th>Nome</th>
            <th>Número</th>
            <th>Email</th>
            <th>Data de nascimento</th>
            <th>Departamento</th>
            <th>Curso</th>
            <th>Perfil</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user) 
            <tr>
                <td>
                    <i class="fas fa-edit" onclick="EditModal({{$user->userId}}, 'User', 'Editar utilizador')" role="button" data-toggle="modal" data-target="#edit"></i>
                    <a href="{{ route ('editUserForm', ['id' => $user->userId])}}"><i class="fas fa-hand-point-up"></i></a>
                </td>
                <td>{{$user->nome}}</td>
                <td>{{$user->numero}}</td>
                <td>{{$user->email}}</td>
                <td>{{ date('d-m-Y', strtotime($user->data_nascimento)) }}</td>
                <td>{{$user->departamento}}</td>
                <td>{{$user->curso}}</td>
                <td>{{$user->perfil}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{$users->links()}}

@if(isset($cudepartamentorso) || isset($curso) || isset($perfil))
    {{$users->appends(['campos' => ['departamento' => $departamento, 'curso' => $curso, 'perfil' => $perfil]])->links()}}
@else
    {{$users->links()}}
@endif

<script>
    $(document).ready(function() {
        $('.pagination a').click(function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            SearchInput('/searchUsers', page);
        });
    });
</script>