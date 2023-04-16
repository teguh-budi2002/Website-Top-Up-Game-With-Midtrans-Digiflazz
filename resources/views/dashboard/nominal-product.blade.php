<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <h1>Tambah Nominal Item</h1>
  <form action="{{ URL('add-nominal-item') }}" method="POST">
    @csrf
    <div>
      <label for="name_item">Nama Item</label>
      <input type="text" id="name_item" name="item_name">
    </div>
    <div>
      <label for="harga">Harga</label>
      <input type="text" id="harga" name="price">
    </div>
    <input type="hidden" name="product_id" value="{{$productId}}">
    @if ($errors->any())
      <ul>
        @foreach ($errors->all() as $err)
        <li>
          {{ $err }}
        </li>
        @endforeach
      </ul>
    @endif
    <button type="submit">Tambah</button>
  </form>
</body>
</html>