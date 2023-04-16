<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Buat Product</title>
</head>
<body>
  <h1>Tambah Produk</h1>
  <form action="{{ URL('add-product') }}" method="POST">
    @csrf
    <div>
      <label for="name_game">Nama Game</label>
      <input type="text" id="name_game" name="name_game">
    </div>
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

  <h2>Semua Product</h2>
  <table>
    <tr>
      <th>Nama Game</th>
      <th>Item Nominal</th>
      <th>Action</th>
    </tr>
    <tr>
      @foreach ($products as $product)
          <td>{{ $product->name_game }}</td>
          @foreach ($product->items as $item)
              <td>{{ $item->item_name }} Rp. {{ number_format($item->price); }}</td>
          @endforeach
          <td>
            <a href="nominal-product/{{ $product->id }}">Tambah Nominal</a>
          </td>
      @endforeach
    </tr>
  </table>
</body>
</html>