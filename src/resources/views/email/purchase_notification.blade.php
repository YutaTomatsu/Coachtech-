<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>商品が購入されました</title>
</head>
<body>
    <p>以下の商品が購入されました。</p>
    <p>商品名: {{ $data['item_name'] }}</p>
    <p>金額: {{ $data['price'] }}円</p>
    <p>購入者名: {{ $data['buyer_name'] }}</p>
    <p>購入日時: {{ $data['date'] }}</p>

    <p>詳細はシステム内で確認してください。</p>

    <p>ご不明な点があれば、お問い合わせください。</p>

    <p>何かご質問やお問い合わせがありましたら、以下の連絡先までお気軽にお問い合わせください。</p>
    <p>メール: example@example.com</p>
    <p>電話番号: 012-3456-7890</p>
</body>
</html>
