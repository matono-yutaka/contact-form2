<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FashionablyLate</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <a class="header__logo" href="">
        FashionablyLate
      </a>
      <div class="admin__button">
        <form class="form" action="<!-- /logout -->" method="post">
        @csrf
        <button class="header-nav__button">logout</button>
        </form>
      </div>

    </div>
  </header>

  <main>
    <div class="admin-form__content">
      <div class="admin-form__heading">
        <h2>Admin</h2>
      </div>
      <form method="GET" action="/admin/search" class="admin-search-form">
        <div class="search-fields">
            <input type="text" name="name" placeholder="名前" value="{{ request('name') }}">
<input type="email" name="email" placeholder="メールアドレス" value="{{ request('email') }}">

<select name="gender">
  <option value="">性別</option>
  <option value="全て" {{ request('gender') == '全て' ? 'selected' : '' }}>全て</option>
  <option value="男性" {{ request('gender') == '男性' ? 'selected' : '' }}>男性</option>
  <option value="女性" {{ request('gender') == '女性' ? 'selected' : '' }}>女性</option>
  <option value="その他" {{ request('gender') == 'その他' ? 'selected' : '' }}>その他</option>
</select>

<select name="category_id">
  <option value="">お問い合わせの種類</option>
  @foreach ($categories as $category)
    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
      {{ $category->content }}
    </option>
  @endforeach

</select>

<input type="date" name="date" value="{{ request('date') }}">
</div> <div class="search-buttons"> <button type="submit">検索</button> <a href="/admin" class="reset-button">リセット</a> <a href="{{-- route('admin.export', request()->query()) --}}" class="export-button">エクスポート</a> </div> </form>
@if (isset($contacts) && $contacts->count())
    <h3>検索結果（{{ $contacts->total() }} 件）：</h3>

    <table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>お名前</th>
            <th>性別</th>
            <th>メールアドレス</th>
            <th>お問い合わせの種類</th>
            <th>詳細</th>
        </tr>
    </thead>
  <tbody>
    @foreach ($contacts as $contact)
    <tr>
      <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
      <td>
        @if ($contact->gender === 1)
          男性
        @elseif ($contact->gender === 2)
          女性
        @else
          その他
        @endif
      </td>
      <td>{{ $contact->email }}</td>
      <td>{{ $contact->category->content ?? '未分類' }}</td>
      <td><button type="button" onclick="openModal('{{ $contact->id }}')">詳細</button></td>
    </tr>
    @endforeach
  </tbody>
</table>

@foreach ($contacts as $contact)
<div id="modal-{{ $contact->id }}" class="modal" style="display:none;">
  <div class="modal-content">
    <span onclick="closeModal('{{ $contact->id }}')" style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:24px;">&times;</span>
    <p><strong>名前：</strong> {{ $contact->first_name }} {{ $contact->last_name }}</p>
    <p><strong>性別：</strong>
      @if ($contact->gender === 1)
        男性
      @elseif ($contact->gender === 2)
        女性
      @else
        その他
      @endif
    </p>
    <p><strong>メール：</strong> {{ $contact->email }}</p>
    <p><strong>お問い合わせ種類：</strong> {{ $contact->category->content }}</p>
    <p><strong>詳細：</strong> {{ $contact->detail }}</p>
  </div>
</div>
@endforeach

@endif

<script>
function openModal(id) {
    document.getElementById('modal-' + id).style.display = 'block';
}
function closeModal(id) {
    document.getElementById('modal-' + id).style.display = 'none';
}
</script>




</main>
</body>
</html>
