# 🐾 SPS(social petworking service) - ペット愛好家のためのSNSアプリ

## 📝 概要

SPSは、ペット好きなユーザー同士が日常の写真・エピソードを投稿・共有し、  
同じ関心を持つ仲間とつながることができるSNSアプリです。

「いいね」「コメント」「フォロー」「チャット」など、交流を深めるための基本機能を実装しており、  
ユーザー同士が温かくゆるやかにつながる空間を目指しています。

---

## 🛠️ 使用技術

- **フロントエンド**: HTML / CSS / JavaScript / Tailwind CSS  
- **バックエンド**: PHP / Laravel / Breeze  
- **インフラ**: Heroku / AWS (Cloud9) / Cloudinary（画像投稿）  
- **認証**: Laravel Breezeによる認証機能

---

## 🎯 制作背景

日々SNSを使っている中で、「ペット好きの人たちがもっと気軽に繋がれる場があればいい」と感じたことが開発のきっかけです。

一般的なSNSでは趣味ごとの繋がりは限定的であるため、**ペット専用のコミュニティ型SNS**として企画・開発しました。

---

## 🌟 主な機能一覧

| 機能 | 説明 |
|------|------|
| 🔐 ユーザー認証 | 登録・ログイン・ログアウト機能（Laravel Breeze） |
| 📝 投稿機能 | テキスト＋画像の投稿が可能（Cloudinary） |
| ❤️ いいね | 投稿へのリアクションが可能 |
| 💬 コメント | 投稿に対するコメントの送信 |
| 🔁 フォロー／フォロワー | 他ユーザーをフォローしてタイムラインをカスタマイズ |
| 📥 チャット（β） | フォロー済ユーザーとのDM機能（簡易版） |

---

## 🧠 工夫した点

- **Tailwind CSSによるモダンなUI設計**
- **Cloudinaryで画像投稿を実現**し、Herokuに負担をかけない構成
- **フォロー・いいね・コメントなどSNSらしい機能の統合**
- **LaravelのMVC設計に沿って、可読性の高いコードを意識**

---

## 🔍 今後の改善予定

- 投稿一覧の無限スクロール対応（現状はページネーション）
- 通知機能（いいね・コメント・フォロー）
- VueまたはReactによるフロントエンド分離構成への刷新
- セキュリティ強化（CSRF/バリデーションの強化）

---

## 📸 スクリーンショット
ホーム画面(投稿一覧画面)
![スクリーンショット 2025-06-04 112607](https://github.com/user-attachments/assets/2fdb0140-2345-4be1-b952-77c6c5affd9a)

ポスト投稿画面
![スクリーンショット 2025-06-04 114213](https://github.com/user-attachments/assets/eb3e7448-8ee1-4f23-a4ed-812502f6ea2c)

いいね(左)・コメントボタン(右)
![スクリーンショット 2025-06-04 114409](https://github.com/user-attachments/assets/df842494-1ad5-485f-9f70-5f440dc8df3e)

コミュニティ画面
![スクリーンショット 2024-09-26 155129](https://github.com/user-attachments/assets/7ad814c3-0866-444c-bc55-d7a1e5affe07)

コミュニティ一覧画面
![スクリーンショット 2025-06-04 113330](https://github.com/user-attachments/assets/0dbf92eb-5b04-455f-adac-38a35c862f7a)

ポストのプレビュー画面
![スクリーンショット 2024-09-21 161729](https://github.com/user-attachments/assets/7aafaffb-ea3c-4a05-a388-1478f44c1249)

ユーザー間でのチャット画面
![スクリーンショット 2025-06-04 113936](https://github.com/user-attachments/assets/7e5d6cc2-9103-4bee-9116-c80f5c7e4b22)

チャット一覧
![スクリーンショット 2024-09-18 145355](https://github.com/user-attachments/assets/a41ce89f-42ac-40e2-b85b-495720722f34)



---

## 🚀 セットアップ方法

```bash
# クローン
git clone https://github.com/yourusername/petmeet.git
cd petmeet

# 環境構築
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate

# DB準備
php artisan migrate --seed

# 起動
php artisan serve
