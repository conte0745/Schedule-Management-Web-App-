# [シフト管理アプリ しふとん](https://nameless-woodland-04388.herokuapp.com/top)

## アプリ概要 
これは小型店舗向けのシフト管理アプリです。1店舗10~20人ほどを想定しています。クルーがシフトを登録することによって、その店舗内のクルーに予定が共有されます。また、任意の期間の総勤務時間や総出勤回数などの就業情報が一覧できるほかに、グループチャット機能や天気予報機能など、スケジュール管理以外の機能が備わっています。

## 開発環境
- php7.4
- laravel6.x
- Vue.js
- cloud9(EC2[amazon linux2])
- mairaDB(local環境)
- postgres(heroku環境)

## 機能
- 会員登録、ログイン、Googleでログイン
- 自分のシフトの登録,閲覧
- 同じグループ内のクルーのシフトの閲覧
- リアルタイムチャット(pusher)
- 天気予報(open weather map, 毎朝6時更新)
- PWA対応

## 注力した機能
注力した機能は週ごとにシフト表示する画面で、直感的に誰がどこにどれくらいの期間はいっているのかを確認することができます。


## デモ画面

- テストアカウント
  - email a@aaaa
  - pass 11111111　

![2021-10-14](https://user-images.githubusercontent.com/77208348/137289189-441327e6-b521-4fdc-b345-7853f7b52688.png)
![2021-10-14 (2)](https://user-images.githubusercontent.com/77208348/137289183-7fac5881-4a23-440c-87b5-340986f47edd.png)

## 環境構築
```
$ git clone https://github.com/conte0745/myapps.git
$ composer update
$ touch .env
```
envファイルを記入する




