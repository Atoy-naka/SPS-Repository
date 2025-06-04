# SPS-Repository

## 📌 概要
このアプリは、○○（例：ペット好き同士が交流できるSNS）を目的として開発しました。  
PHP（Laravel）を使い、ユーザー登録、投稿、コメント、いいね、チャット機能などを実装しています。

## 🎯 目的
- 実践的なWebアプリ開発経験を積むため
- モダンなPHPフレームワーク（Laravel）に習熟するため
- フロントエンドとバックエンドを一貫して構築する力をつけるため

## 🛠️ 使用技術
| 分類 | 技術 |
|------|------|
| 言語 | PHP, HTML, CSS, JavaScript |
| フレームワーク | Laravel, Tailwind CSS |
| 開発環境 | AWS Cloud9 |
| デプロイ | Heroku |
| 認証 | Laravel Breeze |
| 画像管理 | Cloudinary |

## 🔑 主な機能
- ユーザー登録／ログイン（Laravel Breeze認証）
- 投稿（画像 + テキスト）
- いいね機能
- コメント機能
- チャット（ユーザー間）
- コミュニティ機能（カテゴリ別の投稿）
- プロフィール編集

## 📸 スクリーンショット
### ホーム画面
![ホーム画面](./screenshots/home.png)

### 投稿詳細
![投稿詳細](./screenshots/post_detail.png)

### チャット画面
![チャット](./screenshots/chat.png)

※画像ファイルは `screenshots/` フォルダに入れて管理しています。

## 🚀 ローカル環境での起動方法
```bash
git clone https://github.com/Atoy-naka/SPS-Repository.git
cd SPS-Repository
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
