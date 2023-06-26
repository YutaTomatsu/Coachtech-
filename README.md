# Coachtechフリマ
## 概要  
ユーザーは商品の出品や購入、お気に入り登録や出品者とのやりとり、またショップの運営やショップに対するお問い合わせができる。
ショップオーナーは商品の出品やクーポン作成、スタッフの作成やユーザーからのお問い合わせを受け取り、返信することができる。
管理者はショップとユーザーのやり取りの確認、また、全ユーザーに対してメールを一斉送信することができる。


![アプリトップ画像](https://github.com/YutaTomatsu/Coachtech-flea-market/blob/main/%E3%82%A2%E3%83%95%E3%82%9A%E3%83%AA%E3%83%88%E3%83%83%E3%83%95%E3%82%9A%E7%94%BB%E5%83%8F.png)

## 作成した目的  

フリマアプリを作成するため。

## アプリケーションURL

54.95.141.128

## 機能一覧

会員登録機能  
ログイン機能  
ログアウト機能  
パスワードリセット機能
ユーザー、管理者、ショップオーナー、ショップスタッフの4つの権限によるマルチログイン機能
商品出品機能
商品お気に入り追加機能
商品お気に入り削除機能
コメント機能
プロフィール登録機能
プロフィール編集機能
配送先変更機能
クレジットカード、コンビニ払い、銀行振り込みによる決済機能
購入後のレビュー機能
フォロー機能
フォロー解除機能
絞り込み検索機能
ショップ作成機能
ショップ情報編集機能
クーポン作成機能
クーポン削除機能
スタッフ作成機能
スタッフ削除機能
スタッフの権限の制限機能
ユーザーのショップに対するお問い合わせ機能
ショップのユーザーに対する返信機能
お問い合わせを対応済みにする機能
管理者の全ユーザーへのメール一斉送信機能
管理者のユーザーとショップのお問い合わせのやりとり確認機能

## 使用技術 

Laravel 8.83.27

## テーブル設計

![](https://github.com/YutaTomatsu/Coachtech-flea-market/blob/main/%E3%83%86%E3%83%BC%E3%83%95%E3%82%99%E3%83%AB%E7%94%BB%E5%83%8F/table1.png)

![](https://github.com/YutaTomatsu/Coachtech-flea-market/blob/main/%E3%83%86%E3%83%BC%E3%83%95%E3%82%99%E3%83%AB%E7%94%BB%E5%83%8F/table2.png)

![](https://github.com/YutaTomatsu/Coachtech-flea-market/blob/main/%E3%83%86%E3%83%BC%E3%83%95%E3%82%99%E3%83%AB%E7%94%BB%E5%83%8F/table3.png)

![](https://github.com/YutaTomatsu/Coachtech-flea-market/blob/main/%E3%83%86%E3%83%BC%E3%83%95%E3%82%99%E3%83%AB%E7%94%BB%E5%83%8F/table4.png)

![](https://github.com/YutaTomatsu/Coachtech-flea-market/blob/main/%E3%83%86%E3%83%BC%E3%83%95%E3%82%99%E3%83%AB%E7%94%BB%E5%83%8F/table5.png)

![](https://github.com/YutaTomatsu/Coachtech-flea-market/blob/main/%E3%83%86%E3%83%BC%E3%83%95%E3%82%99%E3%83%AB%E7%94%BB%E5%83%8F/table6.png)

![](https://github.com/YutaTomatsu/Coachtech-flea-market/blob/main/%E3%83%86%E3%83%BC%E3%83%95%E3%82%99%E3%83%AB%E7%94%BB%E5%83%8F/table7.png)

## ER図

![ER図](https://github.com/YutaTomatsu/Coachtech-flea-market/blob/main/ER%E5%9B%B3.png)

## 環境構築

### Coachtechフリマプロジェクトの環境構築

このドキュメントでは、Reseプロジェクトのローカル環境をセットアップする方法を説明します。

### 前提条件

- AWSのセットアップが完了していること  

### インストール手順  

#### 1, Dockerのインストール（既にインストール済みの場合は飛ばして下さい）

以下のリンクから自身の環境に合ったDockerをダウンロードします。

[https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)

インストールが完了したらpcを再起動し、以下のコマンドでバージョン情報が返ってくるか確認して下さい。

docker -v

例えば以下のような形でバージョン情報が返ってきたらインストール完了です。

Docker version 20.10.22, build 3a2c30b

#### 2,リポジトリのクローン  

Coachtechフリマプロジェクトを作成したいディレクトリに移動し、以下のコマンドを実行してgitからアプリをcloneします。

git clone https://github.com/YutaTomatsu/Coachtech-flea-market.git

#### 3,プロジェクトのディレクトリに移動してビルド  

以下のコマンドを実行してCoachtech-flea-market内に移動します。

cd Coachtech-flea-market 

デスクトップからdockerを起動した後に以下のコマンドを実行してdocker内にコンテナをbuildします。

docker-compose up -d --build  

dockerのコンテナ内にCoachtech-flea-marketというコンテナが作成されていたら成功です。

#### 4,コンテナに移動し必要な依存関係のインストール  

Coachtech-flea-marketのコンテナ内に移動し、composer installを実行します。  

docker-compose exec php bash（以降コンテナに移動するときはプロジェクトディレクトリからこのコマンドを実行して下さい）  
composer install

#### 5,データベースのマイグレーション実行  

以下のコマンドをコンテナ内で実行してデータベース内にテーブルを作成します。

php artisan migrate

#### 6,アプリケーションの起動

php artisan serve

アプリケーションが正常に起動すると、[http://localhost:10000](http://localhost:10000) からアプリのホーム画面にアクセスできるようになります。  
また、データベースは[http://localhost:8080](http://localhost:8080) からアクセスすることができます。

※アプリが重くなっているため、ローカル環境でページを移動する際にお使いの環境によってはサーバーエラーが発生する場合があります。
その場合、ページを再読み込みする、もしくはアクションを再度実行していただくことで解決できます。

### 7, ダミーデータの作成

必要に応じて、以下のコマンドを実行してあらかじめ作成されたダミーのデータを作成することができます。

php artisan migrate:fresh (エラーが出る場合があるため念のためdb内をfresh)
php artisan db:seed

#### -（ダミーで作成されるアカウント）-

ダミーアカウントを利用する場合は以下のアカウントからそれぞれの権限にログインすることができます。

・ユーザーアカウント

name:ユーザー  
email:user@example.com  
password:12345678  

・管理者アカウント

name:管理者  
email:admin@example.com  
password:12345678  

次に、アプリケーション内の設定をしていきます。



#### 1,queueの実行

以下のコマンドを実行してqueueを起動します。 

php artisan queue:work  

queueを実行することで非同期で実行される管理者の一斉メール送信やコメント通知メールが送信されるようになります。

#### 2,環境切り替え

コンテナ内で以下のコマンドを実行することで、本番環境のデータベースをmigrateし、ダミーデータを作成することができます。

php artisan config:clear

php artisan migrate --seed --env=production (本番環境のmigrateとダミーデータの作成を同時に実行）

これにより、ローカル環境から本番環境で利用しているデータベースにアクセスが可能になります。

以上の工程を実行することで、ローカルの環境構築が完了します。
