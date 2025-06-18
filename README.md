# 🐾 SPS (Social Petworking Service) - ペット愛好家のためのSNSアプリ

## 📝 概要

**SPS**は、ペット好きのユーザー同士が日常の写真やエピソードを投稿・共有し、  
同じ関心を持つ仲間とつながることができる**コミュニティ型SNSアプリ**です。

「いいね」「コメント」「フォロー」「チャット」などの基本機能を実装し、  
温かく、安心してつながれる空間を目指しました。

---

## 🎯 制作背景

日常的にSNSを利用する中で、ペットに特化した交流の場が少ないと感じたことから、  
「**ペット愛好家のための専用SNS**」をテーマに企画・開発しました。

趣味の合う人たちが気軽につながれる空間を、技術とデザインの力で実現することを目指しました。

---

## 🌟 主な機能

| 機能名 | 内容 |
|--------|------|
| 🔐 ユーザー認証 | 新規登録・ログイン・ログアウト（Laravel Breeze） |
| 📝 投稿機能 | テキスト＋画像の投稿（Cloudinary使用） |
| ❤️ いいね | 投稿に対するリアクション |
| 💬 コメント | 投稿へのコメント送信 |
| 🔁 フォロー／フォロワー | タイムラインをカスタマイズ可能 |
| 📥 チャット（β） | フォロー済ユーザーとのDM機能 |

---

## 🛠️ 使用技術

- **フロントエンド**: HTML / CSS / JavaScript / Tailwind CSS  
- **バックエンド**: PHP / Laravel / Laravel Breeze  
- **インフラ・サービス**:
  - **Heroku**: アプリケーションホスティング
  - **Cloud9**: 開発環境
  - **Cloudinary**: 画像アップロード・管理

---

## 🧠 工夫したポイント

- Tailwind CSS を用いた **レスポンシブかつモダンなUI設計**
- Cloudinary を活用した **効率的な画像投稿機能**
- SNSに必要な要素（フォロー・コメント・いいね）を網羅
- LaravelのMVC構造に準拠し、**保守性と拡張性を意識した実装**

---

## 🔧 今後の改善予定

- 投稿一覧の**無限スクロール対応**（現在はページネーション）
- **通知機能**（いいね・コメント・フォロー）
- Vue.js / React などを用いた**フロントエンドのSPA化**
- バリデーション・CSRF対策など**セキュリティ強化**

---

## 📸 スクリーンショット

| 画面 | プレビュー |
|------|------------|
| ホーム（投稿一覧） | ![スクリーンショット 2025-06-04 112607](https://github.com/user-attachments/assets/2fdb0140-2345-4be1-b952-77c6c5affd9a) |
| 投稿画面 | ![スクリーンショット 2025-06-04 114213](https://github.com/user-attachments/assets/eb3e7448-8ee1-4f23-a4ed-812502f6ea2c) |
| いいね・コメントボタン | ![スクリーンショット 2025-06-04 114409](https://github.com/user-attachments/assets/df842494-1ad5-485f-9f70-5f440dc8df3e) |
| コミュニティ画面 | ![スクリーンショット 2024-09-26 155129](https://github.com/user-attachments/assets/7ad814c3-0866-444c-bc55-d7a1e5affe07) |
| コミュニティ一覧 | ![スクリーンショット 2025-06-04 113330](https://github.com/user-attachments/assets/0dbf92eb-5b04-455f-adac-38a35c862f7a) |
| 投稿プレビュー | ![スクリーンショット 2024-09-21 161729](https://github.com/user-attachments/assets/7aafaffb-ea3c-4a05-a388-1478f44c1249) |
| プロフィール＋投稿一覧 | ![Image (2)](https://github.com/user-attachments/assets/865c7db5-cbd8-4089-84c0-0b07fe8a036b) |
| プロフィール編集 | ![スクリーンショット 2025-06-04 124321](https://github.com/user-attachments/assets/d83707f8-db5b-42ec-9bea-08efb1e38e08) |
| チャット画面 | ![スクリーンショット 2025-06-04 113936](https://github.com/user-attachments/assets/7e5d6cc2-9103-4bee-9116-c80f5c7e4b22) |
| チャット一覧 | ![スクリーンショット 2024-09-18 145355](https://github.com/user-attachments/assets/a41ce89f-42ac-40e2-b85b-495720722f34) |

---

## 🔗 リンク

- [リポジトリURL](https://github.com/Atoy-naka/SPS-Repository)

---

## 🪪 ライセンス

このプロジェクトは MIT ライセンスのもとで公開されています。
