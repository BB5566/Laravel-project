<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">一份簡潔的 Laravel 教學與上手範例，包含快速開始、常見問題與實作練習。</p>

---

## Laravel 專案建置與部署流程說明

本文件詳細說明如何從零開始建立一個 Laravel 專案，並將其部署到 GitHub 進行版本控制，同時涵蓋環境設定、資料庫初始化及常用操作。

---

## 目錄

-   [前置準備](#preparation)
-   [本地新建 Laravel 專案](#local-create)
-   [初始化 Git 倉庫並首次提交](#git-init)
-   [在 GitHub 建立遠端倉庫並連結](#github-remote)
-   [從 GitHub Clone 後的標準設定流程](#after-clone)
-   [本地開發環境設定 (XAMPP)](#xampp)
-   [Laravel 核心 MVC 架構](#mvc)
-   [實作教學：Resource Controller / Migration / Seeder / 表單](#resource-tutorial)
-   [新手常見問題與重要觀念](#faq)
-   [快速開始 (Quick Start)](#quick-start)
-   [快速疑難排解 (Quick Troubleshoot)](#quick-troubleshoot)
-   [速查卡（Quick Reference）](#quick-reference)
-   [系統需求（建議）](#system-requirements)
-   [測試（phpunit / SQLite）](#testing)
-   [前端資產（Vite / npm）](#frontend)
-   [.env 常用變數說明（快速）](#env)
-   [部署（生產） Checklist](#deployment)
-   [常用路徑索引](#paths)
-   [Route::resource 小技巧與範例](#route-resource)
-   [練習：建立學生 CRUD（Hands-on 練習）](#exercise-students)
-   [注意事項](#notes)

---

<a name="preparation"></a>

## 前置準備

在開始之前，請確保您的系統已安裝以下軟體：

-   **PHP**: 建議使用 PHP 8.1 或更高版本。
-   **Composer**: PHP 的依賴管理工具。
-   **Node.js & npm/Yarn**: 用於前端資產編譯。
-   **資料庫伺服器**: 例如 MySQL, PostgreSQL, SQLite 等。
-   **XAMPP (選用)**: 如果使用 XAMPP，記得將 Apache 的 DocumentRoot 指向 Laravel 專案中的 `public` 資料夾。

```apache
# 修改 httpd.conf
DocumentRoot "C:/xampp/htdocs/your-project-name/public"
<Directory "C:/xampp/htdocs/your-project-name/public">
```

---

<a name="local-create"></a>

## 1. 本地新建 Laravel 專案

使用 Composer 建立一個新的 Laravel 專案：

```bash
composer create-project "laravel/laravel:^12.0" your-project-name
cd your-project-name
```

---

<a name="git-init"></a>

## 2. 初始化 Git 倉庫並首次提交

進入專案目錄後，初始化 Git 倉庫並提交初始檔案：

```bash
git init
git add .
git commit -m "Initial commit - Laravel project setup"
```

---

<a name="github-remote"></a>

## 3. 在 GitHub 建立遠端倉庫並連結

1. 前往 GitHub 建立一個新的空倉庫。
2. 將本地專案連結到遠端倉庫，並推送內容：

```bash
git remote add origin https://github.com/你的GitHub帳號/你的倉庫名稱.git
git push -u origin main
```

---

<a name="after-clone"></a>

## 4. 從 GitHub Clone 專案後的標準設定流程

當你需要從 GitHub 下載一個現有的 Laravel 專案，請遵循以下步驟：

1. Clone 專案：

```bash
git clone https://github.com/你的GitHub帳號/你的倉庫名稱.git
cd 你的倉庫名稱
```

2. 安裝 PHP 套件：

```bash
composer install
```

3. 建立環境設定檔：

```bash
cp .env.example .env
```

4. 產生應用程式金鑰：

```bash
php artisan key:generate
```

5. 設定資料庫連線：
    - 手動打開 `.env` 檔案，更新以下變數：

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_project # 改成你建立的資料庫名稱
DB_USERNAME=root         # 你的資料庫帳號
DB_PASSWORD=             # 你的資料庫密碼
```

6. 執行資料庫遷移：

```bash
php artisan migrate
```

7. 啟動開發伺服器：

```bash
php artisan serve
```

現在你可以打開 `http://127.0.0.1:8000` 查看專案。

---

<a name="xampp"></a>

## 本地開發環境設定 (XAMPP)

為了讓本地的網址更簡潔 (例如：`http://localhost/` 而不是 `http://localhost/laravel0910/public/`)，需要修改 XAMPP 的 Apache 設定。

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

---

<a name="mvc"></a>

## Laravel 核心 MVC 架構

Laravel 是一個基於 MVC（Model-View-Controller）設計模式的框架，核心運作流程如下：

### 路由 (Route)

-   使用者請求的入口，定義在 `routes/web.php`。
-   它會告訴 Laravel 這個 URL 該由哪個 Controller 的哪個方法來處理。

### 控制器 (Controller)

-   位於 `app/Http/Controllers/`，負責處理主要的商業邏輯。
-   例如，從資料庫讀取資料、驗證使用者輸入等，然後決定要回傳哪個畫面。

### 模型 (Model)

-   位於 `app/Models/`，是 Eloquent ORM 的核心。
-   每個 Model 對應到資料庫中的一個表格，負責所有資料庫的互動操作（新增、查詢、更新、刪除）。

### 視圖 (View)

-   位於 `resources/views/`，負責呈現 HTML 畫面。
-   Controller 會把處理好的資料傳遞給 View，再由 View（通常使用 Blade 模板）將資料渲染出來。

### 資料流向

1. 使用者發出請求 (URL) → Route
2. Route → Controller
3. Controller → Model (操作資料庫)
4. Controller (取得資料) → View
5. View → 回傳 HTML 給使用者

---

<a name="resource-tutorial"></a>

## 實作教學：Resource Controller / Migration / Seeder / 表單

這一節把之前的教學片段整合成一個可實作的流程，包含 Windows/PowerShell 的指令替代，以及最小可複現的程式範例。

### A. 建立 Resource Controller 與 Route

1. 建立 Controller：

```bash
# mac / linux / WSL
php artisan make:controller StudentController --resource

# PowerShell
php artisan make:controller StudentController --resource
```

2. 在 `routes/web.php` 註冊資源路由

```php
use App\Http\Controllers\StudentController;
Route::resource('students', StudentController::class);
```

### Resource Route 對照表

| Verb      | URI                      | Action  | Route Name       |
| --------- | ------------------------ | ------- | ---------------- |
| GET       | /students                | index   | students.index   |
| GET       | /students/create         | create  | students.create  |
| POST      | /students                | store   | students.store   |
| GET       | /students/{student}      | show    | students.show    |
| GET       | /students/{student}/edit | edit    | students.edit    |
| PUT/PATCH | /students/{student}      | update  | students.update  |
| DELETE    | /students/{student}      | destroy | students.destroy |

### B. Controller 範例（index）

```php
// app/Http/Controllers/StudentController.php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // 如果沒有資料庫，先用模擬資料
        // $students = collect([
        //     ['id'=>1,'name'=>'Amy'],
        //     ['id'=>2,'name'=>'Bob']
        // ]);

        // 若已建立 Model 與資料庫，使用 Eloquent
        $students = Student::all();
        return view('student.index', ['data' => $students]);
    }
}
```

### C. Migration 範例

建立 Model 與 migration：

```bash
php artisan make:model Student -m
```

在新建立的 migration 檔案中，修改 `up()`：

```php
public function up(): void
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->integer('age')->nullable();
        $table->timestamps();
    });
}
```

執行 migration：

```bash
php artisan migrate
```

### D. Seeder 範例

建立 seeder：

```bash
php artisan make:seeder StudentSeeder
```

`database/seeders/StudentSeeder.php`：

```php
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create(['name' => 'Amy', 'email' => 'amy@test.com', 'age' => 20]);
        Student::create(['name' => 'Bob', 'email' => 'bob@test.com', 'age' => 22]);
        Student::create(['name' => 'Cat', 'email' => 'cat@test.com', 'age' => 21]);
    }
}
```

執行 seeder：

```bash
php artisan db:seed --class=StudentSeeder
```

### E. 表單 (create / store) 範例

`resources/views/student/create.blade.php`（核心）

```blade
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>新增學生</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">姓名</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">年齡</label>
            <input type="number" class="form-control" id="age" name="age" value="{{ old('age') }}">
        </div>
        <button type="submit" class="btn btn-primary">送出</button>
    </form>
</div>
@endsection
```

Controller `store` 範例：

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:students',
        'age' => 'nullable|integer|min:0',
    ]);

    Student::create($validated);
    return redirect()->route('students.index')->with('success', '學生資料新增成功！');
}
```

### F. 平台指令差異提醒（mac/linux vs PowerShell/Windows）

-   複製 `.env`：

```bash
# mac / linux
cp .env.example .env

# PowerShell
Copy-Item .env.example .env

# CMD
copy .env.example .env
```

-   其他 php / composer / artisan 指令在 PowerShell 下語法相同，僅檔案操作指令不同。

---

<a name="faq"></a>

## 新手常見問題與重要觀念

這個章節整理了幾個 Laravel 新手最常遇到的問題，理解這些觀念可以幫助你節省大量除錯時間。

### 1. 表單提交出現 419 (Page Expired) 錯誤？ -> 缺少 CSRF Token

**原因**: 這是 Laravel 內建的「跨站請求偽造 (CSRF)」保護機制。為了安全，任何會改變後端資料的請求 (POST, PUT, DELETE)，都必須包含一個獨特的 token 來證明這個請求是來自你自己的網站，而不是惡意網站。

**解決方案**: 在你的 Blade 表單 (`<form>`) 中，加入 `@csrf` 指令即可。

```blade
<form method="POST" action="/profile">
    @csrf <!-- 加上這一行 -->
    ...
</form>
```

### 2. `.env` 檔案修改後沒反應？ -> 清除設定快取

**原因**: 為了提升效能，Laravel 會將設定檔 (config 目錄下的所有檔案) 快取成一個單獨的檔案。一旦設定被快取，`.env` 中的任何變更將不會被讀取，直到快取被清除為止。

**解決方案**: 修改完 `.env` 檔案後，執行以下指令來清除快取。

```bash
# 清除設定檔快取
php artisan config:clear

# 開發時，如果路由或畫面有問題，也可以試試以下指令
php artisan route:clear
php artisan view:clear
```

> 注意: `php artisan config:cache` 是在正式環境部署時才使用的指令，開發時請不要執行它。

### 3. 新增/修改資料失敗？ -> Mass Assignment (批量賦值) 保護

**原因**: 當你嘗試用 `Model::create($request->all());` 這樣的方式一次寫入所有表單資料時，可能會遇到錯誤或資料寫入不完整。這是 Laravel 的「批量賦值」保護機制，防止惡意使用者注入非預期的欄位 (例如，偷偷把自己的帳號 `is_admin` 欄位更新為 1)。

**解決方案**: 你必須在對應的 Model 檔案中，明確定義哪些欄位是「可以」被批量賦值的。

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'age',
        // 在這裡加入所有你希望可以透過表單一次新增/更新的欄位
    ];
}
```

### 4. 頁面載入很慢或資料庫查詢太多？ -> N+1 Query 問題

**原因**: 當你在迴圈中讀取關聯資料時，很容易觸發「N+1 查詢問題」。例如，你想顯示 10 篇文章以及它們各自的作者名稱。

**錯誤的寫法**: 會先執行 1 次查詢來撈出 10 篇文章，然後在迴圈中，再分別執行 10 次查詢來找出每篇文章的作者。總共執行了 1 + 10 = 11 次查詢。

```php
// 錯誤的寫法 (N+1 問題)
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->author->name; // 每次迴圈都會執行一次資料庫查詢
}
```

**正確的寫法**: 使用「預加載 (Eager Loading)」，在第一次查詢時就告訴 Laravel 把關聯資料一起撈回來。

```php
// 正確的寫法 (使用 with() 預加載)
// 只會執行 2 次查詢 (1 次查 posts，1 次查所有相關的 authors)
$posts = Post::with('author')->get();
foreach ($posts as $post) {
    echo $post->author->name;
}
```

### 5. `public` 目錄的重要性

請永遠記得，你的網站伺服器 (Apache/Nginx) 的根目錄 (Document Root) 必須指向 Laravel 專案中的 `public` 資料夾，而不是專案的根目錄。這是非常重要的安全設定，可以防止使用者透過網址直接存取到你的 `.env` 檔案、原始碼等敏感資訊。

---

<a name="quick-start"></a>

## 快速開始 (Quick Start)

最短可跑起來的 5 個步驟，適合想立刻啟動專案的人。

1. Clone 專案

```bash
git clone https://github.com/你的GitHub帳號/你的倉庫名稱.git
cd 你的倉庫名稱
```

2. 安裝相依（PHP 與 Node）

```bash
composer install
# 如果有前端資產
npm install
```

3. 複製環境檔並生成 APP_KEY

```bash
# mac / linux
cp .env.example .env

# PowerShell (Windows)
Copy-Item .env.example .env

# CMD
copy .env.example .env

php artisan key:generate
```

4. 執行資料庫遷移與種子（如有）

```bash
php artisan migrate
# 若有 seeder
php artisan db:seed --class=StudentSeeder
```

5. 啟動開發伺服器

```bash
php artisan serve
# 打開 http://127.0.0.1:8000
```

---

<a name="quick-troubleshoot"></a>

## 快速疑難排解 (Quick Troubleshoot)

常見問題與快速修復指令，方便開發時立即排查。

-   表單提交出現 419 (Page Expired)
    -   原因：缺少 CSRF token 或 session 問題。
    -   快速修復：在 Blade 表單加入 `@csrf`，若仍有問題，清除快取並重啟伺服器：

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

-   `.env` 變更沒生效
    -   原因：設定被快取。
    -   修復：

```bash
php artisan config:clear
php artisan cache:clear
```

-   Migration 無法執行（例如資料庫不存在）
    -   確認 `.env` 中 DB\_\* 設定正確，並在資料庫中建立對應資料庫。
    -   若要重置資料庫並重新跑 migration + seeder：

```bash
php artisan migrate:fresh --seed
```

-   Mass Assignment 或 Model::create 失敗

    -   檢查 Model 中的 `$fillable` 是否包含要寫入的欄位。

-   N+1 查詢導致速度慢
    -   使用 eager loading：

```php
$posts = Post::with('author')->get();
```

-   權限或檔案上傳失敗（storage 權限）
    -   Windows: 確認 storage 與 bootstrap/cache 可寫入。
    -   Linux: 設定權限例如 `chown -R www-data:www-data storage bootstrap/cache`（視環境而定）。

---

<a name="quick-reference"></a>

## 常用 Git 操作

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

<a name="notes"></a>

## 注意事項

-   **`.env` 檔案安全**: `.env` 檔案包含敏感資訊，務必確保已加入 `.gitignore`，避免將其推送到遠端倉庫。
-   **依賴包安裝**: 專案的 PHP 依賴包需使用 `composer install` 安裝。在每次切換環境或拉取新代碼後，如果 `composer.lock` 有變動，建議執行此指令。
-   **應用程式金鑰**: `php artisan key:generate` 指令通常只在專案初始化時執行一次。
-   **資料庫前置**: 在執行 `php artisan migrate` 之前，請務必確保資料庫已建立，否則遷移指令將會失敗。
-   **前端資產**: 如果專案包含前端資產（如 CSS/JS），您可能需要運行 `npm install` 或 `yarn install`，然後運行 `npm run dev` 或 `npm run build` 來編譯它們。

---

## 速查卡（Quick Reference）

最短、最常用單行命令速查：

-   Clone + 依賴安裝：

```bash
git clone <repo> && cd <repo> && composer install && npm install    # (如需)
```

-   PHP 擴充（檢查確保已安裝）：

```text
pdo_mysql, pdo_sqlite, mbstring, openssl, tokenizer, xml, ctype, json, gd
```

-   複製 `.env`（平台變體）：

```bash
# mac / linux
cp .env.example .env

# PowerShell (Windows)
Copy-Item .env.example .env

# CMD
copy .env.example .env
```

-   產生 APP_KEY：

```bash
php artisan key:generate
```

-   migrate / seed：

```bash
php artisan migrate && php artisan db:seed --class=StudentSeeder
```

-   啟動伺服器 / build：

```bash
php artisan serve && npm run dev
```

-   測試（unix / windows）：

```bash
# Unix / mac / linux
vendor/bin/phpunit
# Windows PowerShell
.\\vendor\\bin\\phpunit
```

-   Git：

```bash
git add . && git commit -m "msg" && git push origin main
```

-   建立骨架檔：

```bash
php artisan make:controller StudentController --resource && php artisan make:model Student -m && php artisan make:seeder StudentSeeder
```

-   權限（Linux）：

```bash
sudo chown -R www-data:www-data storage bootstrap/cache && sudo chmod -R 775 storage bootstrap/cache
```

---

<a name="system-requirements"></a>

## 系統需求（建議）

建議在本機或 CI 上滿足以下環境，以減少相依性問題：

-   PHP >= 8.1
-   Composer >= 2.0
-   Node >= 16（參考專案的 `vite.config.js`）
-   npm >= 8 或 yarn
-   建議 PHP 擴充：pdo_mysql / pdo_sqlite, mbstring, openssl, tokenizer, xml, ctype, json, gd

> 小提醒：若使用 SQLite 做測試或快速開發，請確認 PHP 已啟用 `pdo_sqlite`。

---

<a name="testing"></a>

## 測試（phpunit / SQLite）

想要在本機快速執行測試，可使用 SQLite 作為輕量測試資料庫。

1. 建立 sqlite 檔案：

```bash
# 在專案根目錄建立檔案
# mac / linux
touch database/database.sqlite
# PowerShell
New-Item database\\database.sqlite -ItemType File
```

2. 在 `.env`（或 `.env.testing`）中設定：

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=${PWD}/database/database.sqlite # 或絕對路徑
```

3. 執行 migration 與測試：

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

> 提示：若你使用 GitHub Actions，通常會在 CI 上建立 sqlite 並直接執行 migration + phpunit。

---

## 前端資產（Vite / npm）

本專案使用 Vite（參考 `vite.config.js`）來打包前端資產。常用命令：

```bash
# 開發（熱重載）
npm run dev

# 建置生產檔
npm run build
```

常見問題：

-   Node 版本過低會導致編譯失敗，請使用 Node 16+。
-   若 CSS/JS 無更新，請確認瀏覽器沒有使用舊快取，或重新啟動 `npm run dev`。

---

## .env 常用變數說明（快速）

-   APP_NAME: 應用名稱
-   APP_ENV: local / production
-   APP_DEBUG: true / false
-   APP_URL: 應用的基礎 URL
-   DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
-   MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD（如有寄信需求）

開發建議：生產環境請務必將 `APP_DEBUG=false`，並把敏感值保存在安全的地方（不要提交到 Git）。

---

## 部署（生產）簡短 Checklist

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

備註：在生產上執行 `config:cache` 前，確認 `.env` 與 `config` 都是正確的；若需要回復設定，可以執行 `php artisan config:clear`。

---

## 常用路徑索引（快速參考）

-   `routes/web.php` — Web 路由定義
-   `app/Http/Controllers/` — Controllers
-   `app/Models/` — Eloquent Models
-   `resources/views/` — Blade templates
-   `database/migrations/` — Migration 檔案
-   `database/seeders/` — Seeder
-   `storage/` — 可寫入檔案（logs、uploads、sessions）

---

## Route::resource 小技巧與範例

使用 `route()` 輔助函式產生 URL：

```blade
<!-- 產生列表頁 URL -->
<a href="{{ route('students.index') }}">學生列表</a>

<!-- 產生編輯頁 URL -->
<a href="{{ route('students.edit', ['student' => $id]) }}">編輯</a>
```

Controller redirect 範例：

```php
return redirect()->route('students.index')->with('success', '儲存成功');
```

---

## 練習：建立學生 CRUD（Hands-on 練習）

目的：透過一步步實作，讓你熟悉 Laravel 的 Model、Migration、Seeder、Controller、Route、Blade 與基本驗證流程。

預計耗時：30–60 分鐘（視熟悉度而定）。

### 目標（驗收標準）

-   能在瀏覽器看到 `/students` 列表頁，顯示測試學生資料。
-   能透過 `/students/create` 表單新增學生，並看到儲存後的導向與成功訊息。
-   能使用 `students.edit` 進行編輯（可選）。

### 步驟（依序執行）

1. 建立 Model + Migration

```bash
php artisan make:model Student -m
```

編輯新 migration，加入 `name`, `email`, `age` 欄位（參考上方 migration 範例），然後執行：

```bash
php artisan migrate
```

2. 建立 Seeder 並填入測試資料

```bash
php artisan make:seeder StudentSeeder
```

在 `database/seeders/StudentSeeder.php` 加入幾筆 `Student::create(...)`，然後執行：

```bash
php artisan db:seed --class=StudentSeeder
```

3. 建立 Resource Controller

```bash
php artisan make:controller StudentController --resource
```

在 `index()` 使用 `Student::all()` 傳資料到 `student.index`，在 `create()` 回傳 `student.create`，在 `store()` 做驗證並 `Student::create($validated)`。

4. 註冊資源路由

在 `routes/web.php` 加入：

```php
Route::resource('students', App\Http\Controllers\StudentController::class);
```

5. 建立 Blade 視圖（簡化）

-   `resources/views/student/index.blade.php`：顯示一個表格，使用 `@foreach ($data as $s)` 列出 `name, email, age`。並加上 "新增學生" 連結到 `route('students.create')`。
-   `resources/views/student/create.blade.php`：使用上面的表單範例，包含 `@csrf` 與錯誤顯示。

6. 瀏覽並驗證

```bash
php artisan serve
# 開啟 http://127.0.0.1:8000/students
```

執行 `Create` 表單，若成功會導回 `students.index` 並顯示成功 flash 訊息。

### PowerShell / Windows 小提示

-   如果要複製 env 檔：`Copy-Item .env.example .env`
-   若要在 PowerShell 執行 phpunit：`vendor\bin\phpunit`

### 進階題（Bonus）

-   加入欄位驗證規則，例如 email 必須唯一。
-   實作 `edit` 與 `update`，並加入刪除功能 `destroy`。
-   實作分頁：在 `index()` 用 `Student::paginate(10)`，並在 Blade 加上 `{{ $data->links() }}`。
-   為 `Student` 建立工廠（Factory）並使用 `DatabaseSeeder` 產生大量假資料。

### 如何檢查自己做得對

-   `php artisan migrate:status` 可確認 migration 是否已跑。
-   進到 `/students`，看到 seed 的資料即代表 `index()` 正確回傳資料。
-   新增一筆後資料庫有新增紀錄且畫面導回，表示 `store()` 正常。

---
