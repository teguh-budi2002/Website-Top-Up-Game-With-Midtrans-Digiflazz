<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Testing</title>
</head>
<body>
  <form action="{{ URL('/checkout') }}" method="post">
    @csrf
    <input type="text" name="qty">
    <select name="item_name" id="">
      @foreach ($products->items as $item)
        <option value="{{ $item->item_name }}">{{ $item->item_name }}</option>
      @endforeach
    </select>
    <select name="price">
      @foreach ($products->items as $item)
        <option value="{{ $item->price }}">{{ $item->price }}</option>
      @endforeach
    </select>
    <input type="text" name="email">
    <input type="text" name="player_id">
    <input type="integer" name="number_phone" placeholder="nomer hp">
    <input type="hidden" name="product_id" value="{{ $products->id }}">
    @if ($errors->any())
        <ul>
          @foreach ($errors->all() as $err)
          <li>
            {{ $err }}
          </li>
          @endforeach
        </ul>
    @endif
    <button type="submimt">Checkout</button>
  </form>
</body>
</html>