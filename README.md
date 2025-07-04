# MVC_backend

## 專案簡介
這是一個基於MVC架構的PHP後端管理系統，使用JWT進行身份驗證，支援會員、產品、訂單等功能模組。

## 環境需求
- PHP 7.4 或更高版本
- MySQL 5.7 或更高版本 / MariaDB
- Apache 或 Nginx 網頁伺服器
- Composer（PHP 依賴管理工具）

## 安裝步驟

### 1. 安裝 Composer

#### Windows 系統：
1. 前往 [Composer 官網](https://getcomposer.org/download/) 下載 `Composer-Setup.exe`
2. 執行安裝程式，跟隨安裝精靈完成安裝
3. 安裝完成後，開啟命令提示字元 (cmd) 或 PowerShell
4. 輸入 `composer --version` 確認安裝成功

#### macOS 系統：
```bash
# 使用 Homebrew 安裝
brew install composer

# 或使用官方安裝腳本
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 2. 複製專案到本地


### 3. 安裝專案依賴套件

```bash
# 切換到專案根目錄
cd c:\xampp\htdocs\backend

# 安裝 Composer 依賴套件
composer install
```

如果 `composer.json` 不存在，請建立一個：

```bash
# 初始化 composer.json
composer init

# 或直接建立 composer.json 檔案（內容見下方）
```

### 4. 建立 composer.json 檔案

在專案根目錄建立 `composer.json` 檔案：

```json
{
    "name": "backend",
    "type": "project",
    "require": {
        "firebase/php-jwt": "^6.0"
    },
    "autoload": {
        "psr-4": {
            "Controllers\\": "app/Controllers/",
            "Models\\": "app/Models/",
            "Middlewares\\": "app/Middlewares/",
            "Vendor\\": "vendor/"
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}
```

### 5. 安裝 JWT 套件

```bash
# 安裝 Firebase JWT 套件
composer require firebase/php-jwt

# 如果需要其他套件，可以類似方式安裝
# composer require 套件名稱
```

### 6. 設定環境變數

```bash
# 複製環境變數範例檔案
cp vendor/.env.example vendor/.env

# 編輯 .env 檔案，填入您的資料庫資訊
```

編輯 `vendor/.env` 檔案內容：

```env
DB_HOST=localhost
DB_NAME=your_database_name
DB_USER=your_username
DB_PASSWORD=your_password
secret_key=your_jwt_secret_key_here
```

### 7. 驗證安裝

```bash
# 檢查 Composer 自動載入是否正常
composer dump-autoload

# 確認 vendor 目錄結構
ls -la vendor/
```

安裝完成後，您的 `vendor/` 目錄應該包含：
- `autoload.php` - Composer 自動載入檔案
- `firebase/` - JWT 套件目錄
- `composer/` - Composer 內部檔案

## 專案樹狀結構

```
MVC_system/
├── app/
│   ├── Controllers/
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── Member.php
│   │   ├── Dashboard.php
│   │   └── OrderDetail.php
│   ├── Models/
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── Member.php
│   │   └── OrderDetail.php
│   ├── Middlewares/
│   │   └── AuthMiddleware.php
├── vendor/
│   ├── autoload.php          # Composer 自動載入
│   ├── firebase/             # JWT 套件
│   ├── Router.php
│   ├── RouteManager.php
│   ├── DB.php
│   └── .env                  # 環境變數（需手動建立）
├── routes/
│   ├── api.php
│   └── web.php
├── public/
│   └── index.php
├── bootstrap/
│   └── Main.php
├── composer.json             # Composer 設定檔
├── composer.lock             # Composer 鎖定檔（自動生成）
└── .env.example
```


## 資料庫架構說明

### 資料庫名稱：`mvc_beverageshop`

### 資料表結構

#### 1. member（會員資料表）
| 欄位名稱 | 資料型態 | 長度 | 說明 | 限制 |
|---------|---------|------|------|------|
| mId | varchar | 10 | 會員ID（主鍵） | NOT NULL, PRIMARY KEY |
| name | varchar | 10 | 會員姓名 | NOT NULL |
| phone | varchar | 10 | 電話號碼 | NOT NULL |
| email | varchar | 25 | 電子郵件 | NOT NULL, UNIQUE |
| password | varchar | 15 | 密碼 | NOT NULL |

#### 2. product（產品資料表）
| 欄位名稱 | 資料型態 | 長度 | 說明 | 限制 |
|---------|---------|------|------|------|
| pId | int | 10 | 產品ID（主鍵） | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| pName | varchar | 10 | 產品名稱 | NOT NULL |
| category | varchar | 10 | 產品分類（茶類、咖啡、熱食） | NOT NULL |
| price | int | 10 | 產品價格 | NOT NULL |
| size | enum | - | 產品尺寸（大、特大） | NOT NULL |
| image_url | varchar | 200 | 產品圖片網址 | NOT NULL |

#### 3. order（訂單資料表）
| 欄位名稱 | 資料型態 | 長度 | 說明 | 限制 |
|---------|---------|------|------|------|
| mId | varchar | 10 | 會員ID（外鍵） | NOT NULL |
| oId | int | 10 | 訂單ID（主鍵） | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| datetime | datetime | 6 | 訂單建立時間 | NOT NULL |
| status | enum | - | 訂單狀態（等待處理、製作中、可取貨、已完成訂單） | NOT NULL |

#### 4. order_detail（訂單明細資料表）
| 欄位名稱 | 資料型態 | 長度 | 說明 | 限制 |
|---------|---------|------|------|------|
| oId | int | 11 | 訂單ID（外鍵、複合主鍵） | NOT NULL, PRIMARY KEY |
| pId | int | 11 | 產品ID（外鍵、複合主鍵） | NOT NULL, PRIMARY KEY |
| quantity | int | 11 | 產品數量 | 可為空 |
| price | int | 11 | 單項總價 | NOT NULL |

#### 5. role（角色資料表）
| 欄位名稱 | 資料型態 | 長度 | 說明 | 限制 |
|---------|---------|------|------|------|
| id | int | 10 | 角色ID（主鍵） | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| name | varchar | 15 | 角色名稱（admin、customer） | NOT NULL |

#### 6. action（動作資料表）
| 欄位名稱 | 資料型態 | 長度 | 說明 | 限制 |
|---------|---------|------|------|------|
| id | int | 11 | 動作ID（主鍵） | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| name | varchar | 20 | 動作名稱 | NOT NULL |

#### 7. role_action（角色權限關聯表）
| 欄位名稱 | 資料型態 | 長度 | 說明 | 限制 |
|---------|---------|------|------|------|
| id | int | 11 | 關聯ID（主鍵） | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| role_id | int | 11 | 角色ID（外鍵） | NOT NULL |
| action_id | int | 11 | 動作ID（外鍵） | NOT NULL |

#### 8. user_role（使用者角色關聯表）
| 欄位名稱 | 資料型態 | 長度 | 說明 | 限制 |
|---------|---------|------|------|------|
| id | int | 11 | 關聯ID（主鍵） | NOT NULL, PRIMARY KEY, AUTO_INCREMENT |
| user_id | varchar | 10 | 使用者ID（外鍵） | NOT NULL |
| role_id | int | 11 | 角色ID（外鍵） | NOT NULL |

### 資料表關聯說明

#### 主要關聯：
- **member** ↔ **order**：一對多關係（一個會員可有多個訂單）
- **order** ↔ **order_detail**：一對多關係（一個訂單可有多個明細）
- **product** ↔ **order_detail**：一對多關係（一個產品可出現在多個訂單明細）

#### 權限控制關聯：
- **member** ↔ **user_role** ↔ **role**：多對多關係（使用者角色分配）
- **role** ↔ **role_action** ↔ **action**：多對多關係（角色權限分配）

#### 外鍵約束：
```sql
-- order_detail 表的外鍵約束
ALTER TABLE order_detail
  ADD CONSTRAINT order_detail_ibfk_1 FOREIGN KEY (oId) REFERENCES order (oId),
  ADD CONSTRAINT order_detail_ibfk_2 FOREIGN KEY (pId) REFERENCES product (pId);
```

## 課後學習心得

> MVC系統架構這門課，不講View，重點在Model跟Controller，所以這塊做好就能拿到不錯的分數了。
> 雖然老師一直強調架構，可能會聽起來有點古板，但假設這是公司系統，應該會維護現有的系統，不太會讓你重構，所以也請遵守程式開發第一原則，程式能動就不要修改程式碼（不要動到老師簡報的架構）

