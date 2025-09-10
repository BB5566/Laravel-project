<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel 專案建置與部署流程說明

本文件詳細說明如何從零開始建立一個 Laravel 專案，並將其部署到 GitHub 進行版本控制，同時涵蓋環境設定、資料庫初始化及常用操作。

---

## 前置準備

在開始之前，請確保您的系統已安裝以下軟體：

*   **PHP**: 建議使用 PHP 8.1 或更高版本。
*   **Composer**: PHP 的依賴管理工具。
*   **Node.js & npm/Yarn**: 用於前端資產編譯。
*   **資料庫伺服器**: 例如 MySQL, PostgreSQL, SQLite 等。

---

## 1. 本地新建 Laravel 專案

首先，使用 Composer 在本地建立一個新的 Laravel 專案。

```bash
composer create-project --prefer-dist laravel/laravel example-app
cd example-app
```

---

## 2. 初始化 Git 倉庫並首次提交

進入專案目錄後，初始化 Git 倉庫並提交初始檔案。

```bash
git init
git add .
git commit -m "Initial commit - Laravel project setup"
```

---

## 3. 在 GitHub 建立遠端倉庫

前往 GitHub 建立一個新的空倉庫。**重要：** 建立時請勾選 **Add a .gitignore**，並選擇 **Laravel** 模板，讓 GitHub 自動為您生成標準的 Laravel `.gitignore` 檔案。

---

## 4. 連結遠端倉庫並拉取內容

將本地專案連結到您剛才建立的 GitHub 遠端倉庫，並拉取遠端內容。

```bash
git remote add origin https://github.com/你的GitHub帳號/你的倉庫名稱.git
git pull origin main --allow-unrelated-histories
```

*   **處理 `.gitignore` 衝突：** 如果在拉取過程中遇到 `.gitignore` 或其他檔案的衝突，請手動合併衝突後，執行以下指令提交合併結果：

    ```bash
    git add .gitignore
    git commit -m "Merge remote .gitignore"
    ```

---

## 5. 推送本地內容到遠端

將本地專案的所有內容推送到 GitHub 遠端倉庫。

```bash
git push -u origin main
```

---

## 6. Laravel 專案環境設定

### 複製環境設定檔

複製 `.env.example` 檔案並重新命名為 `.env`。此檔案將包含您的環境變數和敏感資訊。

```bash
cp .env.example .env
```

### 設定資料庫連線

開啟 `.env` 檔案，根據您的資料庫設定修改以下變數：

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 建立資料庫

在您的資料庫管理系統中（例如 MySQL Workbench, phpMyAdmin 或指令行），建立一個新的資料庫，名稱需與 `.env` 中的 `DB_DATABASE` 一致。

```sql
CREATE DATABASE your_database_name;
```

### 產生應用程式金鑰

生成 Laravel 應用程式所需的加密金鑰。

```bash
php artisan key:generate
```

### 執行資料庫遷移

運行資料庫遷移指令，建立資料庫表格。

```bash
php artisan migrate
```

---

## 7. 運行 Laravel 應用程式

在專案根目錄下，啟動 Laravel 開發伺服器：

```bash
php artisan serve
```

通常，應用程式會在 `http://127.0.0.1:8000` 運行。

---

## 8. 常用 Git 操作

### 從遠端拉取更新

```bash
git pull origin main
```

### 新增變更並提交

```bash
git add .
git commit -m "描述修改內容"
```

### 推送更新到遠端

```bash
git push origin main
```

---

## 注意事項

*   **`.env` 檔案安全：** `.env` 檔案包含敏感資訊，務必確保已加入 `.gitignore`，避免將其推送到遠端倉庫。
*   **依賴包安裝：** 專案的 PHP 依賴包需使用 `composer install` 安裝。在每次切換環境或拉取新代碼後，如果 `composer.lock` 有變動，建議執行此指令。
*   **應用程式金鑰：** `php artisan key:generate` 指令通常只在專案初始化時執行一次。
*   **資料庫前置：** 在執行 `php artisan migrate` 之前，請務必確保資料庫已建立，否則遷移指令將會失敗。
*   **前端資產：** 如果專案包含前端資產（如 CSS/JS），您可能需要運行 `npm install` 或 `yarn install`，然後運行 `npm run dev` 或 `npm run build` 來編譯它們。

---