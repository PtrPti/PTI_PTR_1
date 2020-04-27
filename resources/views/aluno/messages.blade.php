
  <ul class="messages" >
    @isset($messages)
    
    @foreach($messages as $message)
      <li class="message clearfix">
        <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'recieved'}}">
          <p>{{$message->message}}</p>
          <p class="date">{{date('d M y, h:i a', strtotime($message->created_at)) }}</p>
        </div>
      </li>
    @endforeach
  @endisset    
  </ul>

  <div class="input-text">
    <input type="text" name="message" class="submit writeMessage">
    <i class="fa fa-paper-plane fa-2x sendMessageIcon"></i>
  </div>
