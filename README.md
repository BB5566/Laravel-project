<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# Laravel 學習筆記與實踐手冊

一份涵蓋 Laravel 專案從建置、開發到部署的完整筆記，整合了 MVC 核心架構、資料庫操作、Blade 模板以及常見問題排解，旨在成為一份高效的速查手冊與實作指南。

---

## 目錄

- [1. 環境建置與前置準備](#1-環境建置與前置準備)
  - [軟體需求](#軟體需求)
  - [本地開發環境設定 (XAMPP)](#本地開發環境設定-xampp)
- [2. 專案生命週期與 Git 工作流](#2-專案生命週期與-git-工作流)
  - [A. 在本地建立新專案](#a-在本地建立新專案)
  - [B. 初始化 Git 並推送到 GitHub](#b-初始化-git-並推送到-github)
  - [C. 從 GitHub Clone 現有專案後的標準設定流程](#c-從-github-clone-現有專案後的標準設定流程)
- [3. Laravel 核心 MVC 架構詳解](#3-laravel-核心-mvc-架構詳解)
  - [資料流向](#資料流向)
  - [A. 路由 (Route)](#a-路由-route)
  - [B. 控制器 (Controller)](#b-控制器-controller)
  - [C. 視圖 (View - Blade 模板)](#c-視圖-view---blade-模板)
  - [D. 模型 (Model)](#d-模型-model)
- [4. 實作練習：建立學生資料 CRUD](#4-實作練習建立學生資料-crud)
  - [Step 1: 建立路由與 Resource Controller](#step-1-建立路由與-resource-controller)
  - [Step 2: 建立 Model 與 Migration](#step-2-建立-model-與-migration)
  - [Step 3: 建立 Seeder 填入假資料](#step-3-建立-seeder-填入假資料)
  - [Step 4: 實作 Controller 與 View (列表 & 新增)](#step-4-實作-controller-與-view-列表--新增)
  - [Step 5: 驗證成果](#step-5-驗證成果)
- [5. 新手常見問題與重要觀念 (FAQ)](#5-新手常見問題與重要觀念-faq)
  - [Q1: 表單提交出現 419 (Page Expired) 錯誤？](#q1-表單提交出現-419-page-expired-錯誤)
  - [Q2: .env 檔案修改後沒生效？](#q2-env-檔案修改後沒生效)
  - [Q3: 使用 Model::create() 新增/修改資料失敗？](#q3-使用-modelcreate-新增修改資料失敗)
  - [Q4: 頁面載入很慢或資料庫查詢太多？](#q4-頁面載入很慢或資料庫查詢太多)
  - [Q5: public 目錄的重要性？](#q5-public-目錄的重要性)
- [6. 速查卡 (Cheatsheet)](#6-速查卡-cheatsheet)
  - [常用 Artisan 指令](#常用-artisan-指令)
  - [常用 Git 指令](#常用-git-指令)
  - [平台指令差異 (macOS/Linux vs Windows)](#平台指令差異-macoslinux-vs-windows)
- [7. 進階主題與參考資料](#7-進階主題與參考資料)
  - [測試 (phpunit / SQLite)](#測試-phpunit--sqlite)
  - [前端資產 (Vite / npm)](#前端資產-vite--npm)
  - [部署（生產）Checklist](#部署生產checklist)
  - [.env 常用變數說明](#env-常用變數說明)
  - [常用路徑索引](#常用路徑索引)

---

## 1. 環境建置與前置準備

### 軟體需求
開始前，請確保系統已安裝以下軟體：
- **PHP**: 建議使用 8.1 或更高版本。
- **Composer**: PHP 的依賴管理工具。
- **資料庫伺服器**: 例如 MySQL, MariaDB, PostgreSQL 等。
- **Node.js & npm/Yarn**: 用於前端資源編譯 (Vite)。
- **Git**: 版本控制工具。

### 本地開發環境設定 (XAMPP)
為了讓本地網址更簡潔 (例如 `http://localhost/` 而不是 `http://localhost/laravel0910/public/`)，需要修改 XAMPP 的 Apache 設定。這是非常重要的一步，也能避免安全風險。

1.  開啟 XAMPP 控制台，點擊 Apache 旁的 `Config` 按鈕，選擇 `Apache (httpd.conf)`。
2.  找到 `DocumentRoot` 和 `<Directory>` 這兩行設定。
3.  將路徑指向你 Laravel 專案中的 `public` 資料夾。

```apache
# 註解掉原始設定
# DocumentRoot "C:/xampp/htdocs"
# <Directory "C:/xampp/htdocs">

# 新增指向 Laravel 專案 public 資料夾的設定
DocumentRoot "C:/xampp/htdocs/laravel0910/public"
<Directory "C:/xampp/htdocs/laravel0910/public">
```
4. 修改存檔後，重新啟動 (Stop/Start) Apache 服務。

---

## 2. 專案生命週期與 Git 工作流

### A. 在本地建立新專案
使用 Composer 建立一個新的 Laravel 12.x 專案：
```bash
composer create-project "laravel/laravel:^12.0" laravel0910
cd laravel0910
```

### B. 初始化 Git 並推送到 GitHub
1.  初始化 Git 倉庫並首次提交：
    ```bash
    git init
    git add .
    git commit -m "Initial commit - Laravel project setup"
    ```
2.  在 GitHub 建立新倉庫並連結：
    ```bash
    git remote add origin https://github.com/你的 GitHub 帳號/你的倉庫名稱.git
    git push -u origin main
    ```

### C. 從 GitHub Clone 現有專案後的標準設定流程
這是團隊協作或更換開發環境時的標準流程：
1.  **Clone 專案**
    ```bash
    git clone https://github.com/chengkk0910/laravel_20250910.git your-project-name
    cd your-project-name
    ```
2.  **安裝 PHP 套件**
    ```bash
    composer install
    ```
3.  **建立環境檔 (`.env`)**
    ```bash
    # Windows (CMD)
    copy .env.example .env
    # macOS / Linux / Git Bash
    cp .env.example .env
    ```
4.  **產生應用程式金鑰 (APP_KEY)**
    ```bash
    php artisan key:generate
    ```
5.  **設定資料庫連線**
    手動打開 `.env` 檔案，更新 `DB_*` 相關變數：
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel_0910 # 改成你在 phpMyAdmin 建立的資料庫名稱
    DB_USERNAME=root # 你的資料庫帳號
    DB_PASSWORD= # 你的資料庫密碼
    ```
6.  **執行資料庫遷移 (Migration)**
    ```bash
    php artisan migrate
    ```
7.  **(選用) 填充初始資料 (Seeder)**
    ```bash
    php artisan db:seed --class=YourSeederClassName
    ```

---

## 3. Laravel 核心 MVC 架構詳解
Laravel 基於 MVC (Model-View-Controller) 設計模式，理解其運作流程是掌握框架的關鍵。

### 資料流向
> **使用者請求 (URL) → [Route] → [Controller] → [Model (操作資料庫)] → [Controller (取得資料)] → [View (渲染畫面)] → 回傳 HTML 給使用者**

### A. 路由 (Route)
- **位置**: `routes/web.php`
- **功能**: 應用程式的入口，定義 URL 與 Controller 方法之間的對應關係。
- **範例**: 使用 `Route::resource` 可以一行程式碼快速建立對應一個資源的完整 CRUD 路由。
  ```php
  use App\Http\Controllers\StudentController;

  // 這行會自動產生 index, create, store, show, edit, update, destroy 等路由
  Route::resource('students', StudentController::class);
  ```
- **Resource Route 對照表**:

| Verb      | URI                      | Action    | Route Name       |
| :-------- | :----------------------- | :-------- | :--------------- |
| `GET`     | `/students`              | `index`   | `students.index` |
| `GET`     | `/students/create`       | `create`  | `students.create`|
| `POST`    | `/students`              | `store`   | `students.store` |
| `GET`     | `/students/{student}`    | `show`    | `students.show`  |
| `GET`     | `/students/{student}/edit` | `edit`    | `students.edit`  |
| `PUT/PATCH` | `/students/{student}`    | `update`  | `students.update`|
| `DELETE`  | `/students/{student}`    | `destroy` | `students.destroy` |

### B. 控制器 (Controller)
- **位置**: `app/Http/Controllers/`
- **功能**: 處理主要的商業邏輯。它接收來自路由的請求，可能會與 Model 互動來操作資料，最後決定要回傳哪個 View。
- **建立指令**:
  ```bash
  # --resource 會自動建立好對應 CRUD 的七個方法
  php artisan make:controller StudentController --resource
  ```
- **範例 (index 方法)**:
  ```php
  // in app/Http/Controllers/StudentController.php
  public function index()
  {
      // dd() 是 Laravel 非常好用的除錯工具，會停止程式並顯示變數內容
      // dd('hello students index dd');

      // 假設 $data 是從資料庫取出的資料陣列
      $data = [
          ['id' => 1, 'name' => 'amy'],
          ['id' => 2, 'name' => 'bob'],
          ['id' => 3, 'name' => 'cat'],
      ];

      // 將 $data 傳遞給名為 'student.index' 的 View
      return view('student.index', ['data' => $data]);
  }
  ```

### C. 視圖 (View - Blade 模板)
- **位置**: `resources/views/`
- **功能**: 負責呈現 HTML 畫面。Blade 是 Laravel 強大的模板引擎，支持模板繼承、流程控制等功能。
- **模板繼承**:
  - **主佈局 (Master Layout)**: `resources/views/layouts/app.blade.php`
    ```html
    <!DOCTYPE html>
    <html>
    <head>
        <title>App Name - @yield('title')</title>
    </head>
    <body>
        @section('sidebar')
            This is the master sidebar.
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
    </html>
    ```
  - **子視圖 (Child View)**: `resources/views/child.blade.php`
    ```blade
    @extends('layouts.app')

    @section('title', 'Page Title')

    @section('sidebar')
    @parent {{-- 保留父層 sidebar 的內容 --}}
    <p>This is appended to the master sidebar.</p>
    @endsection

    @section('content')
    <p>This is my body content.</p>
    @endsection
    ```
- **在 View 中顯示資料**:
  ```blade
  {{-- in resources/views/student/index.blade.php --}}
  @foreach ($data as $value)
      <tr>
          <td>{{ $value['id'] }}</td>
          <td>{{ $value['name'] }}</td>
          <td>
              {{-- 使用 route() 輔助函式產生 URL --}}
              <a href="{{ route('students.edit', ['student' => $value['id']]) }}">Edit</a>
          </td>
      </tr>
  @endforeach
  ```

### D. 模型 (Model)
- **位置**: `app/Models/`
- **功能**: Eloquent ORM 的核心，每個 Model 對應到資料庫中的一個資料表，負責所有資料庫互動。
- **建立指令**:
  ```bash
  # -m 或 --migration 會同時建立對應的 migration 檔案
  php artisan make:model Student -m
  ```
- **Eloquent ORM vs. Query Builder (DB Facade)**
  Laravel 提供兩種主要方式與資料庫互動：
  - **Eloquent ORM (建議)**: 這是 Laravel 的特色，將資料表映射為物件 (Model)。程式碼更具可讀性、更直觀，且能輕鬆處理資料表之間的關聯。絕大多數情況下，你都應該優先使用 Eloquent。
    ```php
    // 取得所有學生資料
    $students = Student::all();
    // 找到 ID 為 1 的學生
    $student = Student::find(1);
    ```
  - **Query Builder (DB Facade)**: 提供一個流暢的介面來建立和執行資料庫查詢，更接近原生 SQL。當你需要處理非常複雜的查詢或 JOIN 操作，而 Eloquent 無法輕易達成時，可以使用它。
    ```php
    use Illuminate\Support\Facades\DB;

    // 取得所有學生資料
    $students = DB::table('students')->get();
    // 執行原生查詢 (如你的筆記中所示)
    $users = DB::select('select * from users where active = ?', [1]);
    ```
  你的筆記中有提到 `DB::select`，這就是使用 Query Builder 執行原生查詢的方式。對於初學者，建議先專注於 Eloquent。

---

## 4. 實作練習：建立學生資料 CRUD

### Step 1: 建立路由與 Resource Controller
```bash
# 建立 Controller
php artisan make:controller StudentController --resource
```
在 `routes/web.php` 註冊路由：
```php
use App\Http\Controllers\StudentController;
Route::resource('students', StudentController::class);
```

### Step 2: 建立 Model 與 Migration
```bash
# 建立 Student Model 和對應的 migration 檔案
php artisan make:model Student -m
```
接著，編輯 `database/migrations/xxxx_xx_xx_xxxxxx_create_students_table.php` 檔案，定義資料表欄位：
```php
public function up(): void
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamps();
    });
}
```
執行 migration 來建立資料表：
```bash
php artisan migrate
```

### Step 3: 建立 Seeder 填入假資料
```bash
php artisan make:seeder StudentSeeder
```
編輯 `database/seeders/StudentSeeder.php`：
```php
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create(['name' => 'amy', 'email' => 'amy@test.com']);
        Student::create(['name' => 'bob', 'email' => 'bob@test.com']);
        Student::create(['name' => 'cat', 'email' => 'cat@test.com']);
    }
}
```
執行 Seeder：
```bash
php artisan db:seed --class=StudentSeeder
```
你可以在 phpMyAdmin 中看到 `students` 資料表已經有這三筆資料。

### Step 4: 實作 Controller 與 View (列表 & 新增)
修改 `StudentController` 的 `index` 方法：
```php
use App\Models\Student; // 記得 use Model

public function index()
{
    $students = Student::all(); // 使用 Eloquent 取得所有學生資料
    return view('student.index', ['data' => $students]);
}
```
建立列表 View: `resources/views/student/index.blade.php`
```blade
<h1>學生列表</h1>
<a href="{{ route('students.create') }}">新增學生</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
```

### Step 5: 驗證成果
啟動開發伺服器：
```bash
php artisan serve
```
打開瀏覽器，前往 `http://127.0.0.1:8000/students`，你應該能看到學生列表。

---

## 5. 新手常見問題與重要觀念 (FAQ)

#### Q1: 表單提交出現 419 (Page Expired) 錯誤？
- **原因**: 缺少 CSRF Token。這是 Laravel 的安全機制，防止跨站請求偽造。
- **解決方案**: 在你的 `<form>` 標籤內，加上 `@csrf` 指令。
  ```html
  <form method="POST" action="{{ route('students.store') }}">
      @csrf
      ...
  </form>
  ```

#### Q2: `.env` 檔案修改後沒生效？
- **原因**: Laravel 為了效能會快取設定檔。
- **解決方案**: 在開發時，修改 `.env` 後執行以下指令清除快取。
  ```bash
  php artisan config:clear
  ```

#### Q3: 使用 `Model::create()` 新增/修改資料失敗？
- **原因**: Mass Assignment (批量賦值) 保護機制。預設情況下，Eloquent Model 會阻擋所有欄位的批量賦值，以防惡意注入非預期欄位。
- **解決方案**: 在 Model 檔案中，使用 `$fillable` 屬性明確定義哪些欄位是「可以」被批量賦值的。
  ```php
  // app/Models/Student.php
  class Student extends Model
  {
      protected $fillable = [
          'name',
          'email',
          // 其他允許的欄位
      ];
  }
  ```

#### Q4: 頁面載入很慢或資料庫查詢太多？
- **原因**: N+1 Query 問題。當你在迴圈中讀取關聯資料時，很容易觸發。
- **解決方案**: 使用 `with()` 進行「預加載 (Eager Loading)」。
  ```php
  // 錯誤的寫法 (N+1 問題)
  // $posts = Post::all();

  // 正確的寫法 (只會執行 2 次查詢)
  $posts = Post::with('author')->get();

  foreach ($posts as $post) {
      echo $post->author->name; // 不會觸發額外查詢
  }
  ```

#### Q5: `public` 目錄的重要性？
- **說明**: 請永遠記得，你的網站伺服器 (Apache/Nginx) 的根目錄 (Document Root) 必須指向 Laravel 專案中的 `public` 資料夾，而不是專案根目錄。這能防止使用者透過網址直接存取到你的 `.env` 檔案、原始碼等敏感資訊。

---

## 6. 速查卡 (Cheatsheet)

### 常用 Artisan 指令

| 指令                                     | 說明                   |
| :--------------------------------------- | :--------------------- |
| `php artisan serve`                      | 啟動開發伺服器         |
| `php artisan make:controller NameController --resource` | 建立 Resource Controller |
| `php artisan make:model ModelName -m`    | 建立 Model 和 Migration |
| `php artisan make:seeder SeederName`     | 建立 Seeder            |
| `php artisan migrate`                    | 執行資料庫遷移         |
| `php artisan migrate:fresh --seed`       | 重設資料庫並執行所有 Seeder |
| `php artisan db:seed --class=SeederName` | 執行指定的 Seeder      |
| `php artisan key:generate`               | 產生新的 APP_KEY       |
| `php artisan config:clear`               | 清除設定檔快取         |
| `php artisan route:clear`                | 清除路由快取           |
| `php artisan view:clear`                 | 清除視圖快取           |

### 常用 Git 指令

| 指令                           | 說明               |
| :----------------------------- | :----------------- |
| `git clone <repo-url>`         | Clone 遠端倉庫     |
| `git pull origin main`         | 從遠端拉取最新變更 |
| `git add .`                    | 將所有變更加入暫存區 |
| `git commit -m "Your Message"` | 提交變更           |
| `git push origin main`         | 將提交推送到遠端   |

### 平台指令差異 (macOS/Linux vs Windows)

**複製 `.env` 檔案**
```bash
# macOS / Linux
cp .env.example .env

# Windows (PowerShell)
Copy-Item .env.example .env

# Windows (CMD)
copy .env.example .env
```

---

## 7. 進階主題與參考資料

### 測試 (phpunit / SQLite)
想要在本機快速執行測試，可使用 SQLite 作為輕量測試資料庫。

1.  **建立 sqlite 檔案**：
    ```bash
    # 在專案根目錄建立檔案

    # mac / linux
    touch database/database.sqlite

    # PowerShell
    New-Item database\database.sqlite -ItemType File
    ```
2.  **在 `.env`（或 `.env.testing`）中設定**：
    ```ini
    DB_CONNECTION=sqlite
    DB_DATABASE=${PWD}/database/database.sqlite # 或絕對路徑
    ```
3.  **執行 migration 與測試**：
    ```bash
    php artisan migrate

    # 建議（跨平台、Laravel 推薦）
    php artisan test

    # 直接使用 phpunit（若需要）
    # Unix / mac / linux
    vendor/bin/phpunit

    # Windows PowerShell 或 CMD
    vendor\bin\phpunit
    ```

### 前端資產 (Vite / npm)
本專案使用 Vite（參考 `vite.config.js`）來打包前端資產。常用命令：
```bash
# 安裝依賴
npm install

# 開發（熱重載）
npm run dev

# 建置生產檔
npm run build
```

### 部署（生產）Checklist
以下為生產環境上線前的常見步驟：
```bash
# 在生產機上
composer install --no-dev --optimize-autoloader
npm run build

# 設定 env
php artisan key:generate

# 快取設定與路由
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 遷移資料庫
php artisan migrate --force

# 設定檔案權限（範例，視服務器 user/group 調整）
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### .env 常用變數說明
- `APP_NAME`: 應用名稱
- `APP_ENV`: `local` (開發) / `production` (生產)
- `APP_DEBUG`: `true` (開發時顯示詳細錯誤) / `false` (生產時關閉)
- `APP_URL`: 應用的基礎 URL
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`...（寄信功能設定）

### 常用路徑索引
- `routes/web.php` — Web 路由定義
- `app/Http/Controllers/` — Controllers
- `app/Models/` — Eloquent Models
- `resources/views/` — Blade templates
- `database/migrations/` — Migration 檔案
- `database/seeders/` — Seeder
- `public/` — 網站根目錄，所有公開資源放這裡
- `storage/` — 可寫入檔案（logs、uploads、cache、sessions）
- `.env` — 環境變數設定檔