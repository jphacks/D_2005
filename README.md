# Pripla

Princess & Prince date planning service.

### コマンド

```bash
# 環境構築
$ make setup
# 開発用サーバとコンテナの起動
# フロントエンド: localhost:3000
# バックエンド: localhost:8000
$ make up
# コンテナの終了
$ make down
# Dockerのプロセス確認
$ make ps
# シェルの起動
$ make sh
# DBにテーブル作成 + シーダーの実行
$ make db
# Tinkerの起動
$ make tinker
# Linterによるコード修正
$ make lint
```

### API

- タイムラインの取得

Endpoint

```
GET /api/v0/tl
```

Request

```json

```

Response

```json

```

- デートプラン詳細の取得

Endpoint

```
GET /api/v0/detail
```

Request

```json

```

Response

```json

```

- 地域（都道府県）一覧の取得

Endpoint

```
GET /api/v0/prefectures
```

Request

```json
{}
```

Response

```json
[
  {
    "id": 1,
    "name": "兵庫県"
  },
  ...
]
```

- 予算の一覧の取得

Endpoint

```
GET /api/v0/budget
```

Request

```json

```

Response

```json

```

- ターゲット（男/女/どちらでも可）の取得

Endpoint

```
GET /api/v0/target
```

Request

```json

```

Response

```json

```

- 投稿

Endpoint

```
GET /api/v0/post
```

Request

```json

```

Response

```json

```