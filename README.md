# [シフト管理アプリ しふとん](https://nameless-woodland-04388.herokuapp.com/top)

## アプリ概要 
小型店舗向けのシフト管理アプリ。1店舗10~20人ほどを想定。クルーがシフトを登録することによって、その店舗内のクルーに予定が共有される。また、任意の期間の総勤務時間や総出勤回数などの就業情報が一覧できるほかに、グループチャット機能や天気予報機能など、スケジュール管理以外の機能が備わっている。

## 機能
- 会員登録、ログイン、Googleでログイン
- 自分のシフトの登録,閲覧
- 同じグループ内のクルーのシフトの閲覧
- リアルタイムチャット(pusher)
- 天気予報(open weather map, 毎朝6時更新)
- PWA対応

## 注力した機能
注力した機能は週ごとにシフト表示する画面で、直感的に誰がどこにどれくらいの期間はいっているのかを確認することが可能。  
また、人によって権限を分けることで、管理がしやすくなる。

## デモ画面

- テストアカウント
  - email a@aaaa
  - pass 11111111　

![2021-10-14](https://user-images.githubusercontent.com/77208348/137289189-441327e6-b521-4fdc-b345-7853f7b52688.png)
![2021-10-14 (2)](https://user-images.githubusercontent.com/77208348/137289183-7fac5881-4a23-440c-87b5-340986f47edd.png)

## 開発環境
- php7.4
- laravel6.x
- Vue.js
- Bootstrap
- MySQL
- nginx
- Docker
  - php:7.4-fpm-buster
  - node:16-alpine
  - nginx:1.20-alpine
  - mysql/mysql-server:8.0

## 環境構築
```
$ git clone https://github.com/conte0745/myapps.git
$ docker compose up -d
```
コンテナ内のworkディレクトリで
```
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate
$ php artisan api:weather 
```
env.exampleファイルを参考に.envファイルに環境変数を記入していく。以下使用したAPI。  
- [OpenWeatherMap](https://openweathermap.org/forecast5)
- [Google login](https://developers.google.com/identity/sign-in/web/sign-in?authuser=1)
- [Google mail](https://support.google.com/mail/answer/7126229?hl=ja)
- [PUSHER](https://pusher.com)
- [LINE](https://notify-bot.line.me/). 

全て記入した上でSSL化したlocalhostにアクセスすれば完了する（はず）.   
https://localhost
