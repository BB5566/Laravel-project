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

## 學習筆記 (2025-09-10)

這份筆記記錄了使用 Laravel 12 建立一個基本 CRUD 專案的過程，涵蓋了從安裝、環境設定、路由、控制器到視圖的完整流程。

### 1. 安裝與初始化

#### 1.1 建立專案
使用 Composer 來建立一個新的 Laravel 專案。
```bash
# 建立一個名為 laravel0910 的 Laravel 12 專案
composer create-project "laravel/laravel:^12.0" laravel0910
```
指令執行後，會建立一個名為 `laravel0910` 的資料夾。

#### 1.2 進入專案目錄並檢視 Artisan 指令
進入專案目錄後，可以透過 `php artisan` 指令來查看所有可用的指令。
```bash
# 進入專案目錄
cd laravel0910/

# 列出所有 artisan 指令
php artisan
```
> 筆記中顯示安裝的版本為 **Laravel Framework 12.28.1**。

### 2. 本地開發環境設定 (XAMPP)

為了讓本地的網址更簡潔 (例如：`http://localhost/` 而不是 `http://localhost/laravel0910/public/`)，需要修改 XAMPP 的 Apache 設定。

#### 2.1 修改 Apache (`httpd.conf`)
1.  開啟 XAMPP 控制台。
2.  點擊 Apache 模組旁的 **Config** 按鈕。
3.  選擇 **Apache (httpd.conf)**。
4.  找到 `DocumentRoot` 和 `<Directory>` 的設定。
5.  將路徑指向您 Laravel 專案中的 `public` 資料夾。

```apache
# 註解掉原始設定
# DocumentRoot "C:/xampp/htdocs"
# <Directory "C:/xampp/htdocs">

# 新增指向 Laravel 專案 public 資料夾的設定
DocumentRoot "C:/xampp/htdocs/laravel0910/public"
<Directory "C:/xampp/htdocs/laravel0910/public">
```
完成修改後，重新啟動 (Stop/Start) Apache 服務。

### 3. MVC 核心概念 - Resource Controller

Laravel 的 Resource Controller 可以讓我們用一行指令就建立出處理 CRUD (Create, Read, Update, Delete) 所需的所有方法。

#### 3.1 建立 Resource Controller
使用 `--resource` 參數來建立一個 Resource Controller。
```bash
# 建立一個名為 StudentController 的 Resource Controller
php artisan make:controller StudentController --resource
```
這個指令會在 `app/Http/Controllers/` 目錄下建立 `StudentController.php` 檔案。

#### 3.2 建立路由 (Route)
接著，需要在 `routes/web.php` 中註冊這個 Controller。
```php
// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController; // 記得要 use

// 這單行程式碼會自動建立對應到 Controller 中所有資源方法的多個路由
// 資源名稱建議使用複數 (students)
Route::resource('students', StudentController::class);
```

#### 3.3 Resource Route 對應表
`Route::resource()` 會建立以下 RESTful 風格的路由：

| Verb      | URI                    | Action  | Route Name          |
| :-------- | :--------------------- | :------ | :------------------ |
| GET       | `/students`            | index   | `students.index`    |
| GET       | `/students/create`     | create  | `students.create`   |
| POST      | `/students`            | store   | `students.store`    |
| GET       | `/students/{student}`  | show    | `students.show`     |
| GET       | `/students/{student}/edit` | edit    | `students.edit`     |
| PUT/PATCH | `/students/{student}`  | update  | `students.update`   |
| DELETE    | `/students/{student}`  | destroy | `students.destroy`  |

### 4. 視圖 (View) 與資料傳遞

#### 4.1 建立 Blade 視圖檔案
1.  在 `resources/views/` 資料夾下，建立一個名為 `student` 的子資料夾。
2.  在 `student` 資料夾內，建立一個 `index.blade.php` 檔案。

基本的 HTML 結構如下：
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
</head>
<body>
    <h1>Hello student index</h1>
</body>
</html>
```

#### 4.2 從 Controller 回傳 View
修改 StudentController 中的 index 方法，使其回傳剛剛建立的視圖。
```php
// app/Http/Controllers/StudentController.php
public function index()
{
    // 使用 '資料夾名稱.檔案名稱' 的格式
    return view('student.index');
}
```
現在，訪問 `http://localhost/students` 應該就能看到 "Hello student index" 的畫面了。

#### 4.3 除錯技巧：`dd()`
當路由或 Controller 沒有如預期般運作時，可以使用 `dd()` (Dump and Die) 函式來中斷程式執行並印出變數或訊息，非常適合用來除錯。
```php
// app/Http/Controllers/StudentController.php
public function index()
{
    // 程式會在這裡停止，並在瀏覽器上顯示字串
    dd('hello students index dd');
}

public function create()
{
    dd('hello students create');
}
```
執行結果會在瀏覽器上顯示 `"hello students index dd"`。

#### 4.4 Controller 傳遞資料到 View
在 Controller 準備好資料陣列，並將其作為第二個參數傳遞給 `view()` 函式。
```php
// app/Http/Controllers/StudentController.php
public function index()
{
    $data = [
        [
            'id' => 1,
            'name' => 'amy',
        ],
        [
            'id' => 2,
            'name' => 'bob',
        ],
        [
            'id' => 3,
            'name' => 'cat',
        ]
    ];

    // 將 $data 陣列傳遞到 view 中，view 裡面就可以使用名為 'data' 的變數
    return view('student.index', ['data' => $data]);
}
```

#### 4.5 在 Blade 模板中顯示資料
使用 Blade 的 `@foreach` 語法來迭代陣列，並顯示資料。同時，使用 `route()` 輔助函式來產生編輯頁面的連結。
```blade
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $value)
                <tr>
                    <td>{{ $value['id'] }}</td>
                    <td>{{ $value['name'] }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('students.edit', ['student' => $value['id']]) }}">edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
```

### 5. Git 與專案協作

#### 5.1 Clone 專案
從 GitHub repository clone 專案到本地。
```bash
git clone https://github.com/chengkk0910/laravel_20250910.git laravelAll
```

#### 5.2 初始化 Cloned 專案
從 Git clone 下來的專案缺少 `vendor` 目錄和 `.env` 環境檔，需要手動設定。

1.  **安裝 PHP 套件**
    ```bash
    composer install
    ```
2.  **建立環境檔**
    ```bash
    cp .env.example .env
    ```
3.  **產生 APP_KEY**
    ```bash
    php artisan key:generate
    ```
4.  **設定資料庫**
    手動編輯 `.env` 檔案，填寫正確的資料庫連線資訊 (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`)。
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_0910
    DB_USERNAME=root
    DB_PASSWORD=
    ```
5.  **執行資料庫遷移**
    這個指令會根據 `database/migrations` 裡面的檔案，在資料庫中建立對應的資料表。
    ```bash
    php artisan migrate
    ```
composer install

建立環境檔 

Bash

cp .env.example .env

產生 APP_KEY 

Bash

php artisan key:generate

設定資料庫 

手動編輯 

.env 檔案，填寫正確的資料庫連線資訊 (DB_DATABASE, DB_USERNAME, DB_PASSWORD)。 

程式碼片段

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_0910
DB_USERNAME=root
DB_PASSWORD=
執行資料庫遷移

這個指令會根據 

database/migrations 裡面的檔案，在資料庫中建立對應的資料表。 

Bash

php artisan migrate