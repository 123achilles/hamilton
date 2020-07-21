<div><span>user email--</span><span>{{$user->email}}</span><span> user name-</span><span>{{$user->name}}</span></div>

<div>shfjshdfsdfdhfs</div>
<img src="{{public_path('storage/images/question/ground.jpg')}}" alt="h2">
<h2>asdjsajdj</h2>
<div>dfsdfsdfsd</div>
<div>
    fssdfsdf <span>fsdfsdfsf</span>
</div>
<img src="{{public_path('storage/images/question/ground.jpg')}}" alt="">
<div>dsafsdf</div>

<hr>
<br>
@foreach($choices as $value)

    <div>
        @if(empty($value[0]['question']['question_img']))
            <div class="question">{{$value[0]['question']['question']}}</div>
        @else
            <img  class="question" src="{{public_path('storage/images/question/'.$value[0]['question']['question_img'])}}" alt="question">
            <div class="question">{{$value[0]['question']['question']??""}}</div>
        @endif
        @if(count($value) > 1)
            @foreach($value as $item)
                <div>{{$item['title']}}</div>
            @endforeach
        @else
            @if(!empty($value[0]['title']))
                <div>{{$value[0]['title']}}</div>
            @else
                <img src="{{public_path('storage/images/choice/'.$value[0]['choice_img'])}}" alt="choice">
            @endif
        @endif
    </div>
    <hr>
@endforeach

@foreach($questions as $val)
    @if(empty($val['question_img']))
        <div class="question">{{$val['question']}}</div>
    @else
        <img class="question" src="{{public_path('storage/images/question/'.$val['question_img'])}}" alt="question">
        <div class="question">{{$val['question']??""}}</div>
    @endif
    <div>{{$val['answer']}}</div>
@endforeach


<style>
    .question{
        font-size: 20px;
        font-style: italic;
        text-align: center;
        padding: 25px;
        margin: 15px;
    }
</style>
