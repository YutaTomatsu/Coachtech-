<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新しいコメントが届きました</title>
</head>
<body>
    <p>
        {{ $data['buyer_name'] }}さんが{{ $data['item_name'] }}にコメントしました。
    </p>
    <p>
        「コメント内容」
    </p>
    <p>
        {{ $comment->comment }}
    </p>
</body>

</html>
