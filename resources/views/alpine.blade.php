@extends('layout')

@section('content')
  <h1 x-data="{ message: 'I ❤️ Alpine' }" x-text="message"></h1>

  <form method="POST" action="{{ route('store') }}" x-data="items">
    @csrf

    <div class="contrainer p-5">
      <table class="table table-dark h-100">
        <thead>
          <tr class="text-center">
            <th scope="col">Tên</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Chi tiết</th>
            <th scope="col">Giá</th>
            <th scope="col">Đặt hàng</th>
          </tr>
        </thead>
        <tbody>
          <template x-for="(item, index) in items" :key="item.id">
            <tr class="text-center">
              <td x-text="item.name"></td>
              <td><img :src="'{{ asset('storage/') }}/' + item.picture" alt="item.name" width=75 height=75></td>
              <td x-text="item.des"></td>
              <td x-text="item.price"></td>
              <td>
                <div class="contrainer d-flex justify-content-center h-100">
                  <div x-data="{ count: 0 }" x-on:click="updateOrder(item, count)">
                    <button type="button" x-on:click="count > 0 ? count-- : null">-</button>
                    <span x-text="count" :id="item.name"></span>
                    <button type="button" x-on:click="count++">+</button>
                  </div>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
      <ul class="pagination justify-content-center">
        {{ $items->links() }}
      </ul>
      <div class="container bg-secondary bg-gradient rounded p-4">
        <div class="mb-3">
          <label for="name" class="form-label">Nhập tên</label>
          <input type="text" class="form-control" id="name" name="name">
          @if ($errors->has('name'))
            <div class="alert alert-danger mt-1">{{ $errors->first('name') }}</div>
          @endif
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Nhập số điện thoại</label>
          <input type="text" class="form-control" id="phone" name="phone">
          @if ($errors->has('phone'))
            <div class="alert alert-danger mt-1">{{ $errors->first('phone') }}</div>
          @endif
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email">
          @if ($errors->has('email'))
            <div class="alert alert-danger mt-1">{{ $errors->first('email') }}</div>
          @endif
        </div>
        <div class="mb-3">
          <label for="note" class="form-label">Ghi chú</label>
          <input type="text" class="form-control" id="note" name="note">
        </div>
        <div class="container d-flex justify-content-end mt-3">
          @if ($errors->has('orders'))
            <div class="alert alert-danger m-2">{{ $errors->first('orders') }}</div>
          @endif
          <input type="text" class="m-2" name="total" id="total" x-bind:value="totalPrice" readonly>
          <input type="hidden" name="orders" x-bind:value="formatOrders(orders)">
          <input type="hidden" name="total" x-bind:value="totalPrice">
          <button type="submit" class="btn btn-success m-2">Đặt hàng</button>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('js')
  <script>
    let items = @json($items);

    document.addEventListener('alpine:init', () => {
      Alpine.data('items', () => ({
        items: items.data,
        orders: {},
        totalPrice: 0,
        updateOrder: function(item, count) {
          if (count > 0) {
            this.orders[item.name] = count;
          } else {
            delete this.orders[item.name];
          }
          this.updateTotalPrice();
        },
        updateTotalPrice: function() {
          this.totalPrice = 0;
          for (let item of this.items) {
            if (this.orders[item.name]) {
              this.totalPrice += this.orders[item.name] * item.price;
            }
          }
        },
        formatOrders: function(orders) {
          return Object.entries(orders)
            .map(([key, value]) => `${key}(${value})`)
            .join(', ');
        }
      }))
    });
  </script>
@endsection
