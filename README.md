# [シフト管理アプリ しふとん](https://nameless-woodland-04388.herokuapp.com/top)

## アプリ概要 
これは小型店舗向けのシフト管理アプリです。1店舗10~20人ほどを想定しています。クルーがシフトを登録することによって、その店舗内のクルーに予定が共有されます。また、任意の期間の総勤務時間や総出勤回数などの就業情報が一覧できるほかに、グループチャット機能や天気予報機能など、スケジュール管理以外の機能が備わっています。

## 開発環境
- php7.3
- laravel6.x
- Vue.js
- cloud9(EC2[amazon linux2])
- mairaDB(local環境)
- postgres(heroku環境)

## 機能
- 会員登録、ログイン
- 自分のシフトの登録,閲覧
- 同じグループ内のクルーのシフトの閲覧
- リアルタイムチャット(pusher)
- 天気予報(open weather map, 毎朝6時更新)
- PWA対応

## 注力した機能
注力した機能は週ごとにシフト表示する画面で、直感的に誰がどこにどれくらいの期間はいっているのかを確認することができます。


## デモ画面
<img width="960" alt="monthly" src="https://user-images.githubusercontent.com/77208348/137287907-71206f5d-8c73-4ec2-af6f-e7e2c09caf58.png">
<img width="960" alt="weekly" src="https://user-images.githubusercontent.com/77208348/137287930-0ff117c4-0dad-4f3c-91df-abd21a4808bf.png">


