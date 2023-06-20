@extends('layouts.no_item')

<head>
    <link href="{{ asset('css/success.css') }}" rel="stylesheet">
</head>

@section('content')

<body class="body">
    <div class="thanks__box">
        <h1>ご購入ありがとうございます。</h1>
        <p>コンビニ支払いや銀行振り込みの場合は、手続きを完了させて下さい。
        </p>
        <a class="home" href="{{ route('home') }}">
            <div class="home">ホームに戻る</div>
        </a>
    </div>
</body>

@endsection
