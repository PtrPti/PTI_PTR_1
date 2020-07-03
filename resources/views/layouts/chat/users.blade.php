@foreach ($utilizadores as $utilizador)
    <div class="chat_list" id="{{$utilizador->id}}"> 
        @if($utilizador->unread)
            <span class="pending">{{ $utilizador->unread }}</span>
        @endif
        <div class="chat_people">
            <div class="chat_img"> <img src="{{ asset('images/user.png') }}" width=30px class="media-object"> </div>
            <div class="chat_ib">
                <h5>{{$utilizador->nome}}<span class="chat_date">{{ date('d M', strtotime($utilizador->lm_date)) }}</span></h5>
                <p>{{ str_limit($utilizador->last_message, $limit = 35, $end = '...') }}</p>
            </div>
        </div>
    </div>
@endforeach