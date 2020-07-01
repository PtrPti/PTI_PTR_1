@foreach ($utilizadores as $utilizador)
    <div class="chat_list" id="{{$utilizador->id}}"> 
       
        <div class="chat_people"> <!--quando clica tem de acrescentar a class active-->
           
            <div class="chat_ib">
                <h5>{{$utilizador->nome}}<span class="chat_date">{{ date('d M', strtotime($utilizador->lm_date)) }}</span></h5>
               
            </div>
        </div>
    </div>
@endforeach